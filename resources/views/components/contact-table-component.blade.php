@php
    $currentSort = request('sort', 'last_name_1'); // If no 'sort', we assume 'last_name_1'
    $currentDirection = request('direction', 'asc'); // If no 'direction', we assume 'asc'
    $newDirection = ($currentSort === 'last_name_1' && $currentDirection === 'asc') ? 'desc' : 'asc';
@endphp

<div class="row mt-2 mt-sm-4 mx-lg-2">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th class="d-flex justify-content-between align-items-center">
                    <span>Surname <span class="d-none d-sm-inline">1</span></span>
                    <a href="{{ route('contacts.index', array_merge(request()->all(), ['sort' => 'last_name_1', 'direction' => $newDirection])) }}" class="text-decoration-none float-end">
                        <i class="fa-solid fa-sort"></i>
                    </a>
                </th>
                
                <th class="d-none d-sm-table-cell">Surname 2</th>
                <th class="d-none d-lg-table-cell">Email</th>
                <th class="d-none d-md-table-cell">Mobile phone</th>
                <th class="d-none d-md-table-cell">Notes</th>
                <th class="text-center">Photo</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($contacts as $contact)
                <tr>
                    <td class="align-middle">{{ $contact->first_name }}</td>
                    <td class="align-middle">{{ $contact->last_name_1 }}</td>
                    <td class="align-middle d-none d-sm-table-cell">{{ $contact->last_name_2 }}</td>
                    <td class="align-middle d-none d-lg-table-cell">{{ $contact->email }}</td>
                    <td class="align-middle d-none d-md-table-cell">{{ $contact->mobile }}</td>
                    <td class="align-middle d-none d-md-table-cell text-center">{!! $contact->notes ? '<i class="fa-solid fa-circle-check fa-lg text-success"></i>' : '<i class="fa-solid fa-circle-xmark fa-lg text-danger"></i>' !!}</td>
                    <td class="align-middle text-center">
                        <img src="{{ $contact->image ? asset('storage/' . $contact->image) : asset('images/profile1.png') }}" 
                             alt="Contact image" 
                             class="img-thumbnail" 
                             style="width: 40px; height: 40px; object-fit: cover;">
                    </td>
                    <td class="align-middle">
                        <div class="d-flex d-flex justify-content-around">
                            <a href="{{ route('contacts.show', ['contact' => $contact, 'user_id' => request()->query('user_id')] + request()->only(['sort', 'direction', 'search'])) }}" class="btn btn-primary btn-sm linkView">
                                <i class="fa-solid fa-eye me-1"></i>
                                <span class="d-none d-md-inline">View</span>
                            </a>
                            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                @can('delete', $contact)
                                    <!-- If the user is admin or has the permission to delete this contact, this button is shown -->
                                    <button type="submit" class="btn btn-danger btn-sm linkDelete delete-button">
                                        <i class="fa-solid fa-trash-can me-1"></i>
                                        <span class="d-none d-md-inline">Delete</span>
                                    </button>
                                @else
                                    <!-- If the user doesn't has the permission to delete this contact, this button is disabled -->
                                    <button type="button" class="btn btn-danger btn-sm linkDelete delete-button" disabled>
                                        <i class="fa-solid fa-trash-can mx-1"></i>
                                        <span class="d-none d-md-inline">Delete</span>
                                    </button>
                                @endcan
                            </form>                            
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center p-0">
                        <div class="py-3 d-flex justify-content-center align-items-center no-contacts">
                            <i class="fa-solid fa-users-slash"></i>
                            <div class="mx-4">
                                <span>-</span>
                                <span class="mx-3">No contacts found</span>
                                <span>-</span>
                            </div>
                            <i class="fa-solid fa-users-slash"></i>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- This component is only rendered in the index view, so we can specify the CSS styles
directly inside the component. --}}

<style>

    /* ==== TABLE STYLES ==== */

    .table th {
        background-color: #212529;
        color: white;
    }

    .table td {
        background-color: rgb(228, 228, 228);
        color: black;
    }

    .table tbody tr:hover td:not(:last-child) {
        background-color: #212529e3;
        color: white;
    }

    /* Sort icon */
    .table .fa-sort {
        cursor: pointer;
        color: white;
    }

    /* Action buttons */
    .table .btn-primary {
        color: white;
        background-color: green;
        border: green;
        box-shadow: 0 0 5px #212529; /* Color and intensity */
        outline: none;
    }

    .table .btn-primary:hover {
        color: white;
        background-color: rgba(0, 128, 0, 0.582);
        border: rgba(0, 128, 0, 0.582);
    }

    .table .btn-danger {
        color: white;
        background-color: red;
        border: red;
        box-shadow: 0 0 5px #212529; /* Color and intensity */
        outline: none;
    }

    .table .btn-danger:hover {
        color: white;
        background-color: rgba(255, 0, 0, 0.582);
        border: rgba(255, 0, 0, 0.582);
    }

    .table .btn-danger[disabled] {
        background-color: rgba(0, 0, 0, 0.432);
        border: rgba(0, 0, 0, 0.432);
        color: black;
        opacity: 0.4;
    }

    .no-contacts{
    font-size: 1.3rem;
    background-color: rgb(95, 95, 95);
    color: white;
}

@media (max-width: 360px) {
    th{
        font-size: 0.9rem;
    }
    td {
        font-size: 0.8rem;
    }
    td i {
        font-size: 0.8em;
    }

    td .btn{
        margin: 3px;
        padding: 0;
    }
}

@media (max-width: 430px) {
    .no-contacts{
        font-size: 0.8rem;
    }
}

</style>