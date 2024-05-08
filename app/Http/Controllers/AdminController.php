<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use App\Models\Marque;


class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::withCount('cars')->with('cars')->get();
        $cars = Car::with('owner', 'marque')->get();
        $marques = Marque::with('cars')->get();

        return view('admin.dashboard', compact('users', 'cars', 'marques'));
    }


    public function addmarque(Request $request){
        
            // Validate the request data
            $request->validate([
                'name' => 'required|string|unique:marques',
                
            ]);
    
            // Create a new instance of the Marque model
            $marque = new Marque;
    
            // Assign values from the request to the Marque model attributes
            $marque->name = $request->name;
    
            // Check if a logo file was uploaded
    if ($request->hasFile('logo')) {
        $logoFile = $request->file('logo');
        // Generate a unique filename for the logo
        $logoFileName = time() . '_' . $logoFile->getClientOriginalName();
        // Move the logo to the public directory
        $logoFile->move(public_path('marque_logos'), $logoFileName);
        // Assign the logo path to the Marque model attribute
        $marque->logo = 'marque_logos/' . $logoFileName;
    }
            // Save the marque record
            $marque->save();
    
            // Return a success response with the newly created marque
            return redirect()->back()->with('success', 'Marque added successfully');

    
    }


    public function deleteMarque(Marque $marque)
{
    // Delete all associated cars
    Car::where('marque_id', $marque->id)->delete();

    // Delete the marque
    $marque->delete();

    // Redirect back with success message
    return redirect()->back()->with('success', 'Marque and associated cars deleted successfully');
}

public function updateMarque(Request $request, Marque $marque)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming max file size of 2MB
    ]);

    // Retrieve the marque ID from the request
    $marqueId = $request->marqueId;

    // Find the marque by ID
    $marque = Marque::findOrFail($marqueId);

    // Update the marque name
    $marque->name = $request->name;

    // Check if a new logo file was uploaded
    if ($request->hasFile('logo')) {
        $logoFile = $request->file('logo');
        // Generate a unique filename for the logo
        $logoFileName = time() . '_' . $logoFile->getClientOriginalName();
        // Move the new logo to the public directory
        $logoFile->move(public_path('marque_logos'), $logoFileName);
        // Assign the new logo path to the marque
        $marque->logo = 'marque_logos/' . $logoFileName;
    }

    // Save the updated marque to the database
    $marque->save();

    // Redirect back with success message
    return redirect()->back()->with('success', 'Marque updated successfully');
}


public function updateCarStatus(Request $request, Car $car)
{
    // Validate the request data
    $request->validate([
        'confirmation_status' => 'required|in:pending,confirmed,cancelled',
    ]);

    // Update the car status
    $car->confirmation_status = $request->confirmation_status;

    // Save the updated car status to the database
    $car->save();

    // Redirect back with success message
    return redirect()->back()->with('success', 'Car status updated successfully');
}


public function deleteUser(User $user)
{
    // Delete the user along with associated cars
    $user->cars()->delete();
    $user->delete();

    // Redirect back with success message
    return redirect()->back()->with('success', 'User and associated cars deleted successfully');
}

}
