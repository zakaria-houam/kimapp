<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand img {
            max-width: 100px;
            height: auto;
            margin-top: -7px;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #343a40;
            color: #fff;
            padding-top: 60px;
        }
        .sidebar a {
            display: block;
            padding: 10px 15px;
            color: #fff;
            text-decoration: none;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .data-entry {
            background-color: #fff;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .btn-action {
            margin-right: 10px;
        }
        .car_marque{
            background-color: #343a40;
            padding:.5rem;
            color:white;
        }
        nav .container{
            display:flex;
            justify-content:center;
            align-items:center;
        }
        .popup-form {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    z-index: 999;
}

.popup-form h2 {
    margin-bottom: 10px;
}

.popup-form .form-group {
    margin-bottom: 10px;
}

.popup-form input[type="text"],
.popup-form input[type="file"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.popup-form button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.popup-form button:hover {
    background-color: #0056b3;
}
button{
    margin-bottom:1rem;
}

    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            KIM CAR LOCATION
        </a>
        <form class="form-inline" action="/admin/logout" method="POST">
            @csrf
            <button class="btn btn-outline-light" type="submit">Logout</button>
        </form>
    </div>
</nav>

<div class="sidebar">
    <a href="#" class="sidebar-link" data-section="users">USERS</a>
    <a href="#" class="sidebar-link" data-section="cars">CARS</a>
    <a href="#" class="sidebar-link" data-section="marques">MARQUES</a>
</div>

<div class="content">
    <div id="users" class="section">
    <h2>Users</h2>
@foreach($users as $user)
    <div class="data-entry">
        <h3>{{ $user->name }}</h3>
        <p>Email: {{ $user->email }}</p> 
        <p>Phone: {{ $user->phone }}</p>
        <p>Type: {{ $user->user_type }}</p>
        <p>Cars Count: {{ $user->cars_count }}</p>
        <button class="btn btn-primary toggle-cars" data-user="{{ $user->id }}">Toggle Cars</button>
        <div class="cars-list" id="user-{{ $user->id }}-cars" style="display: none;">
            @foreach($user->cars as $car)
                <p>Car Model: {{ $car->model }}</p>
                <p class="car_marque">Car Marque: {{ $car->marque->name }}</p>
            @endforeach
        </div>
        <form action="{{ route('admin.users.delete', $user) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-action">Delete</button>
        </form>
        <button class="btn btn-primary btn-action">Modify</button>
    </div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-cars');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user');
                const carsList = document.getElementById(`user-${userId}-cars`);
                if (carsList.style.display === 'none') {
                    carsList.style.display = 'block';
                } else {
                    carsList.style.display = 'none';
                }
            });
        });
    });
</script>



   

    
</div>

<div id="cars" class="section" style="display: none;">
    <h2>Cars</h2>
@foreach($cars as $car)
    <div class="data-entry">
        <h3>{{ $car->model }}</h3>
        <img src="{{ html_entity_decode($car->pictures) }}" alt="{{ $car->model }}">

        <p>Owner: {{ $car->owner->name }}</p>
        <p>Marque: {{ $car->marque->name }}</p>
        <p>Color: {{ $car->color }}</p>
        <p>Year: {{ $car->year }}</p>
        <p>Confirmation Status:
            <form action="{{ route('admin.car.update', $car) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <select name="confirmation_status">
                    <option value="pending" {{ $car->confirmation_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $car->confirmation_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $car->confirmation_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit">Update</button>
            </form>
        </p>
        <button class="btn btn-primary toggle-details">Toggle Details</button>
        <div class="car-details" style="display: none;">
            <p>Energie: {{ $car->energie }}</p>
            <p>Motor: {{ $car->motor }}</p>
            <p>Price per Day: {{ $car->price_per_day }}</p>
            <p>Wilaya: {{ $car->wilaya }}</p>
            <p>Car Availability: {{ $car->car_availability }}</p>
        </div>
    </div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-details');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const details = this.nextElementSibling;
                if (details.style.display === 'none') {
                    details.style.display = 'block';
                } else {
                    details.style.display = 'none';
                }
            });
        });
    });
</script>

    </div>



<div id="marques" class="section" style="display: none;">
<h2>Marques</h2>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<button id="addMarqueBtn" class="btn btn-success">Add New Marque</button>
@foreach($marques as $marque)
    <div class="data-entry">
        <h3>{{ $marque->name }}</h3>
        @if ($marque->logo)
        <img src="{{ asset($marque->logo) }}" alt="{{ $marque->name }}" width="200px"><br>




        @else
            <p>No Logo Available</p>
        @endif
        
        <button class="btn btn-primary toggle-cars" data-marque="{{ $marque->id }}">Toggle Cars</button>
        <div class="cars-list" id="marque-{{ $marque->id }}-cars" style="display: none;">
            <h4>Cars:</h4>
            @foreach($marque->cars as $car)
            <ul style="display:flex;gap:2rem;">
               
                    <li>{{ $car->model }}</li>
                    <li>{{ $car->year }}</li>
                    <li>{{ $car->color }}</li>
               
            </ul>
            @endforeach
        </div>
        <form action="{{ route('admin.marques.delete', $marque) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-action">Delete</button>
        </form>
        <button class="btn btn-primary btn-action modify-marque" data-marque="{{ $marque->id }}">Modify</button>
    </div>
@endforeach

<!-- Popup form for adding a new marque -->
<div id="addMarqueForm" class="popup-form">
        <form id="newMarqueForm" action="{{ url('admin/addmarque') }}" method="POST" enctype="multipart/form-data">
@csrf
        <h2>Add New Marque</h2>
        <div class="form-group">
            <label for="marqueName">Name:</label>
            <input type="text" id="marqueName" name="name" required>
        </div>
        <div class="form-group">
            <label for="marqueLogo">Logo:</label>
            <input type="file" id="marqueLogo" name="logo" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Marque</button>
        </form>
</div>

<!-- Popup form for modifying marque -->
<div id="modifyMarqueForm" class="popup-form">
<form id="updateMarqueForm" action="{{ route('admin.marques.update', $marque) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')
        <h2>Modify Marque</h2>
        <div class="form-group">
            <label for="modifyMarqueName">Name:</label>
            <input type="text" id="modifyMarqueName" name="name" required value="{{ $marque->name }}">
        </div>
        <div class="form-group">
            <label for="modifyMarqueLogo">Logo:</label>
            <input type="file" id="modifyMarqueLogo" name="logo" accept="image/*">
        </div>
        <input type="hidden" id="marqueId" name="marqueId">
        <button type="submit" class="btn btn-primary">Update Marque</button>
    </form>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-cars');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const marqueId = this.getAttribute('data-marque');
                const carsList = document.getElementById(`marque-${marqueId}-cars`);
                if (carsList.style.display === 'none') {
                    carsList.style.display = 'block';
                } else {
                    carsList.style.display = 'none';
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
    const modifyButtons = document.querySelectorAll('.modify-marque');
    const modifyMarqueForm = document.getElementById('modifyMarqueForm');

    modifyButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get the marque ID from the button's data attribute
            const marqueId = this.getAttribute('data-marque');
            // Populate the form fields with existing marque data
            const marqueName = document.getElementById('modifyMarqueName');
            marqueName.value = ''; // Replace this with the existing marque name
            // Update the hidden input field with the marque ID
            document.getElementById('marqueId').value = marqueId;
            // Display the popup form
            modifyMarqueForm.style.display = 'block';
        });
    });
    // Close popup form when clicking outside of it

});


</script>

    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        const sections = document.querySelectorAll('.section');

        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const sectionName = this.getAttribute('data-section');
                sections.forEach(section => {
                    if (section.id === sectionName) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
    const addMarqueBtn = document.getElementById('addMarqueBtn');
    const addMarqueForm = document.getElementById('addMarqueForm');
    
    // Show popup form when clicking on add marque button
    addMarqueBtn.addEventListener('click', function() {
        addMarqueForm.style.display = 'block';
    });

    // Close popup form when clicking outside of it
    document.body.addEventListener('click', function(event) {
        // Check if the clicked element is not within the popup form
        if (!addMarqueForm.contains(event.target) && event.target !== addMarqueBtn) {
            addMarqueForm.style.display = 'none';
        }
    });
});

document.body.addEventListener('click', function(event) {
        if (!modifyMarqueForm.contains(event.target) && event.target !== modifyButtons) {
            modifyMarqueForm.style.display = 'none';
        }
    });

</script>

</body>
</html>
