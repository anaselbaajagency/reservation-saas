@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des rôles</h1>
    
    <div class="mb-4">
        <button class="btn btn-primary" data-toggle="modal" data-target="#roleModal">
            Créer un nouveau rôle
        </button>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            @foreach($role->permissions as $permission)
                                <span class="badge badge-secondary">{{ $permission->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-role" 
                                    data-id="{{ $role->id }}"
                                    data-name="{{ $role->name }}"
                                    data-permissions="{{ $role->permissions->pluck('id') }}">
                                Modifier
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal pour créer/modifier un rôle -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="roleForm" method="POST">
                @csrf
                <input type="hidden" id="roleId" name="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Créer un nouveau rôle</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nom du rôle</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Permissions</label>
                        @foreach($permissions as $permission)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="permissions[]" 
                                   value="{{ $permission->id }}" 
                                   id="perm_{{ $permission->id }}">
                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Gestion du formulaire
    $('#roleForm').submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        let url = "{{ route('roles.store') }}";
        let method = "POST";
        
        if ($('#roleId').val()) {
            url = "{{ url('admin/roles') }}/" + $('#roleId').val();
            method = "PUT";
        }
        
        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Une erreur est survenue');
            }
        });
    });
    
    // Édition d'un rôle
    $('.edit-role').click(function() {
        let roleId = $(this).data('id');
        let roleName = $(this).data('name');
        let permissions = $(this).data('permissions');
        
        $('#modalTitle').text('Modifier le rôle');
        $('#roleId').val(roleId);
        $('#name').val(roleName);
        
        // Décocher toutes les cases
        $('input[name="permissions[]"]').prop('checked', false);
        
        // Cocher les permissions du rôle
        permissions.forEach(function(permId) {
            $('#perm_' + permId).prop('checked', true);
        });
        
        $('#roleModal').modal('show');
    });
    
    // Nouveau rôle - reset du modal
    $('#roleModal').on('hidden.bs.modal', function () {
        $('#modalTitle').text('Créer un nouveau rôle');
        $('#roleId').val('');
        $('#name').val('');
        $('input[name="permissions[]"]').prop('checked', false);
    });
});
</script>
@endpush