<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use App\Models\Marque;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|string|email|max:255',
        'password' => 'required|string|min:8|confirmed',
        'phone' => 'required|string|max:20',
    ]);

    // Check if the user already exists
    $existingUser = User::where('phone', $request->phone)->first();
    if ($existingUser) {
        return response()->json(['message' => 'User already exists'], 400);
    }

    // Create a new user instance
    $user = new User;
    $user->name = $request->name;
    $user->email = $request->filled('email') ? $request->email : null; // Set email to null if not provided
    $user->password = Hash::make($request->password);
    $user->phone = $request->phone;

    // Save the new user
    $user->save();

    // Generate token for the new user
    $token = Auth::login($user);

    // Return a success response with the token
    return response()->json([
        'message' => 'User created successfully',
        'user' => $user,
        'token' => $token,
    ]);
}

    


public function login(Request $request)
{
    // Validate the request data
    $credentials = $request->validate([
        'phone' => 'required|string|max:20',
        'password' => 'required|string',
    ]);

    // Attempt to authenticate the user by phone number
    if (Auth::attempt(['phone' => $credentials['phone'], 'password' => $credentials['password']])) {
        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        // Eager load the cars owned by the user
        $user->load('cars');

        // Return a success response with user data and token
        return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token]);
    }

    // Return a failure response if authentication fails
    return response()->json(['message' => 'Unauthorized'], 401);
}



public function addcar(Request $request)
{
    // Check if the user is authenticated
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }
    
    // Get the authenticated user's ID
    $userId = Auth::id();

    // Create a new instance of the Car model
    $car = new Car;

   // Process pictures if provided
   if ($request->hasFile('pictures')) {
    $pictures = [];
    foreach ($request->file('pictures') as $picture) {
        // Generate a unique filename for each picture
        $pictureFileName = time() . '_' . $picture->getClientOriginalName();
        // Move the picture to the public directory
        $picture->move(public_path('car_images'), $pictureFileName);
        // Add the picture file path to the pictures array
        $pictures[] = 'car_images/' . $pictureFileName;
    }
    // Convert the pictures array to JSON and store it in the pictures column
    $car->pictures = json_encode($pictures);
}

    // Assign values from the request to the Car model attributes
    $car->model = $request->model;
    $car->year = $request->year;
    $car->color = $request->color;
    $car->energie = $request->energie;
    $marque = Marque::where('name', $request->marque)->first();

    if ($marque) {
        
        $car->marque_id = $marque->id;

        
    } else {
        // Marque does not exist, return a failure response
        return response()->json(['message' => 'Marque does not exist'], 404);
    }
    $car->user_id = $userId; // Assign the authenticated user's ID
    $car->motor = $request->motor;
    $car->wilaya = $request->wilaya;
    $car->price_per_day = $request->price_per_day;

    // Save the car record
    $car->save();

    // Return a success response with the newly created car
    return response()->json(['car' => $car], 200);
}

    public function addmarque(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|unique:marques',
            
        ]);

        // Create a new instance of the Marque model
        $marque = new Marque;

        // Assign values from the request to the Marque model attributes
        $marque->name = $request->name;

        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
        // Generate a unique filename for the logo
        $logoFileName = time() . '_' . $logoFile->getClientOriginalName();
        // Move the new logo to the public directory
        $logoFile->move(public_path('marque_logos'), $logoFileName);
        // Assign the new logo path to the marque
        $marque->logo = 'marque_logos/' . $logoFileName;
        }
        // Save the marque record
        $marque->save();

        // Return a success response with the newly created marque
        return response()->json(['marque' => $marque], 200);
}


public function viewcars(Request $request)
{
    // Retrieve all cars with pagination and eager load the owner relationship
    $cars = Car::with('owner')->paginate(12);

    // Return the cars as JSON response
    return response()->json($cars);
}

public function destroy($id)
{
   

    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }
    else{
        $car = Car::findOrFail($id);

        $userId = Auth::id();

 // Check if the authenticated user owns the car
 if ($car->user_id !== $userId) {
     return response()->json(['message' => 'Unauthorized to delete this car'], 403);
 }
 else{
    $car->delete();
    return response()->json(['message' => 'Car deleted successfully']);
 }
        
        
    }
    
}

public function search($keyword)
    {
        // Search for cars matching the keyword in all columns
        $cars = Car::where(function ($query) use ($keyword) {
            $query->where('model', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('year', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('color', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('energie', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('motor', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('wilaya', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('price_per_day', 'LIKE', '%' . $keyword . '%');
        })->get();

        // Return the matching cars
        return response()->json(['cars' => $cars]);
    }


    public function viewmarques()
    {
        // Retrieve all marques
        $marques = Marque::with('cars')->get();

        // Return the marques as JSON response
        return response()->json(['marques' => $marques]);
    }


    public function filter(Request $request)
    {
        // Retrieve query parameters from the request
        $marque = $request->input('marque');
        $model = $request->input('model');
        $year = $request->input('year');
        $color = $request->input('color');

        // Query cars based on the provided parameters
        $query = Car::query();

        if ($marque) {
            $query->where('marque_id', $marque);
        }

        if ($model) {
            $query->where('model', $model);
        }

        if ($year) {
            $query->where('year', $year);
        }

        if ($color) {
            $query->where('color', $color);
        }

        // Get the filtered cars
        $cars = $query->get();

        // Return the filtered cars as JSON response
        return response()->json(['cars' => $cars]);
    }



    public function modifyCar(Request $request, $id)
{
    // Check if the user is authenticated
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    else{
 // Find the car by ID
 $car = Car::findOrFail($id);

 // Get the authenticated user's ID
 $userId = Auth::id();

 // Check if the authenticated user owns the car
 if ($car->user_id !== $userId) {
     return response()->json(['message' => 'Unauthorized'], 403);
 }

 // Validate incoming request data based on what fields are present
 $validatedData = $request->validate([
     'marque_id' => 'sometimes|required|integer',
     'model' => 'sometimes|required|string|max:255',
     'year' => 'sometimes|required|integer|min:1900|max:' . date('Y'),
     'color' => 'sometimes|required|string|max:255',
     'energy' => 'sometimes|required|string|max:255',
     'motor' => 'sometimes|required|string|max:255',
     'wilaya' => 'sometimes|required|string|max:255',
     'price_per_day' => 'sometimes|required|numeric|min:0',
     'pictures' => 'sometimes|nullable|array',
 ]);

 // Update car details only if the user is authenticated and owns the car
 $car->update($validatedData);

 // Return the updated car object
 return response()->json($car);
    }
   
}



public function deleteUser($id)
{
     // Check if the user is authenticated
     if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    // Get the authenticated user
    $authUser = Auth::user();

    // Check if the authenticated user matches the user to be deleted
    if ($authUser->id != $id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    try {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Check if the user has associated cars
        $hasCars = $user->cars()->exists();

        // Delete the user and their cars if they have any
        DB::transaction(function () use ($user, $hasCars) {
            if ($hasCars) {
                // Delete the associated cars first
                $user->cars()->delete();
            }
            // Then delete the user
            $user->delete();
        });

        return response()->json(['message' => 'User deleted successfully'], 200);
    } catch (\Exception $e) {
        // Handle any exceptions
        return response()->json(['message' => $e->getMessage()], 500);
}

}


public function indexWithCars()
{
    // Retrieve all marques with their associated cars
    $marquesWithCars = Marque::with('cars')->get();

    // Return the data as JSON
    return response()->json($marquesWithCars);
}

}