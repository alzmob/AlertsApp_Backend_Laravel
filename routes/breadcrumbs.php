<?php
// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});


// Dashboard
Breadcrumbs::for('app.dashboard', function ($trail) {
    // $trail->parent('home');
    $trail->push('Dashboard', route('app.dashboard'));
});

// Users
Breadcrumbs::for('app.users.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Users', route('app.users.index'));
});

// Users > Create
Breadcrumbs::for('app.users.create', function ($trail) {
    $trail->parent('app.users.index');
    $trail->push('Create', route('app.users.create'));
});

// Users > Edit
Breadcrumbs::for('app.users.edit', function ($trail, $user) {
    $trail->parent('app.users.index');
    $trail->push($user->first_name, route('app.users.edit', $user->id));
});

// Roles
Breadcrumbs::for('app.roles.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Roles', route('app.roles.index'));
});

// Roles > Create
Breadcrumbs::for('app.roles.create', function ($trail) {
    $trail->parent('app.roles.index');
    $trail->push('Create', route('app.roles.create'));
});

// Roles > Edit
Breadcrumbs::for('app.roles.edit', function ($trail, $role) {
    $trail->parent('app.roles.index');
    $trail->push($role->name, route('app.roles.edit', $role->id));
});

// Permissions
Breadcrumbs::for('app.permissions.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Permissions', route('app.permissions.index'));
});

// Permissions > Create
Breadcrumbs::for('app.permissions.create', function ($trail) {
    $trail->parent('app.permissions.index');
    $trail->push('Create', route('app.permissions.create'));
});

// permissions > Edit
Breadcrumbs::for('app.permissions.edit', function ($trail, $permission) {
    $trail->parent('app.permissions.index');
    $trail->push($permission->name, route('app.permissions.edit', $permission->id));
});


// cities > index
Breadcrumbs::for('app.cities.index', function ($trail) {
    $trail->parent('app.dashboard');
    $trail->push('Cities', route('app.cities.index'));
});

// cities > Create
Breadcrumbs::for('app.cities.create', function ($trail) {
    $trail->parent('app.cities.index');
    $trail->push('Create', route('app.cities.create'));
});

// cities > Edit
Breadcrumbs::for('app.cities.edit', function ($trail, $city) {
    $trail->parent('app.cities.index');
    $trail->push($city->name, route('app.cities.edit', $city->id));
});


// alerts > index
Breadcrumbs::for('app.alerts.index', function ($trail) {
    $trail->parent('app.dashboard');
    $trail->push('Alerts', route('app.alerts.index'));
});

// alerts > Create
Breadcrumbs::for('app.alerts.create', function ($trail) {
    $trail->parent('app.alerts.index');
    $trail->push('Create', route('app.alerts.create'));
});

// alerts > Edit
Breadcrumbs::for('app.alerts.edit', function ($trail, $alert) {
    $trail->parent('app.alerts.index');
    $trail->push($alert->title, route('app.alerts.edit', $alert->id));
});

// alerts > show
Breadcrumbs::for('app.alerts.show', function ($trail, $alert) {
    $trail->parent('app.alerts.index');
    $trail->push($alert->title, route('app.alerts.show', $alert->id));
});
