@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Users</h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Active</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)

                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>@if  ($user->active == "1") <p>✔</p> @else <p></p> @endif </td>
                    <td>@if  ($user->admin == "1") <p>✔</p> @else <p></p> @endif </td>
                    <td>
                        <div class="btn-group btn-group-sm @if($user == auth()-> user()) notusable @endif">
                            <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-success btn-edit
                                   @if($user == auth()->user()) disabled @endif"
                               data-toggle="tooltip" title="Edit {{$user->name}}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#!" class="btn btn-outline-danger btn-delete @if($user == auth()->user()) disabled @endif"
                               data-toggle="tooltip" title="Delete {{$user->name}}"
                               data-id="{{$user->id}}"
                               data-name="{{$user->name}}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('script_after')
    <script>
        $(function () {
            loadTable();

            $('tbody').on('click', '.btn-delete', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let name = $(this).closest('td').data('name');
                let records = $(this).closest('td').data('records');
                // Set some values for Noty
                let text = `<p>Delete the genre <b>${name}</b>?</p>`;
                let type = 'warning';
                let btnText = 'Delete user';
                let btnClass = 'btn-success';
                // If records not 0, overwrite values for Noty
                if (records > 0) {
                    text += `<p>ATTENTION: you are going to delete ${records} records at the same time!</p>`;
                    btnText = `Delete genre + ${records} records`;
                    btnClass = 'btn-danger';
                    type = 'error';
                }

                // Show Noty
                let modal = new Noty({
                    timeout: false,
                    layout: 'center',
                    modal: true,
                    type: type,
                    text: text,
                    buttons: [
                        Noty.button(btnText, `btn ${btnClass}`, function () {
                            // Delete genre and close modal
                            deleteUser(id);
                            modal.close();
                        }),
                        Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                            modal.close();
                        })
                    ]
                }).show();
            });
            $('tbody').on('click', '.btn-edit', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let name = $(this).closest('td').data('name');
                // Update the modal
                $('.modal-title').text(`Edit ${name}`);
                $('form').attr('action', `/admin/users/${id}`);
                $('#name').val(name);
                $('input[name="_method"]').val('put');
                // Show the modal
                $('#modal-genre').modal('show');
            });
            $('#modal-genre form').submit(function (e) {
                // Don't submit the form
                e.preventDefault();
                // Get the action property (the URL to submit)
                let action = $(this).attr('action');
                // Serialize the form and send it as a parameter with the post
                let pars = $(this).serialize();
                console.log(pars);
                // Post the data to the URL
                $.post(action, pars, 'json')
                    .done(function (data) {
                        console.log(data);
                        // Noty success message
                        new Noty({
                            type: data.type,
                            text: data.text
                        }).show();
                        // Hide the modal
                        $('#modal-genre').modal('hide');
                        // Rebuild the table
                        loadTable();
                    })
                    .fail(function (e) {
                        console.log('error', e);
                        // e.responseJSON.errors contains an array of all the validation errors
                        console.log('error message', e.responseJSON.errors);
                        // Loop over the e.responseJSON.errors array and create an ul list with all the error messages
                        let msg = '<ul>';
                        $.each(e.responseJSON.errors, function (key, value) {
                            msg += `<li>${value}</li>`;
                        });
                        msg += '</ul>';
                        // Noty the errors
                        new Noty({
                            type: 'error',
                            text: msg
                        }).show();
                    });
            });
        });

        // Delete a user
        function deleteUser(id) {
            // Delete the user from the database
            let pars = {
                '_token': '{{ csrf_token() }}',
                '_method': 'delete'
            };
            $.post(`/admin/users/${id}`, pars, 'json')
                .done(function (data) {
                    console.log('data', data);
                    // Show toast
                    new Noty({
                        type: data.type,
                        text: data.text
                    }).show();
                    // Rebuild the table
                    loadTable();
                })
                .fail(function (e) {
                    console.log('error', e);
                });
        }
    </script>
@endsection