@csrf
<div class="row">
    <div class="col-8">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Name"
                   required
                   value="{{ old('name', $user->name) }}">
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="email@email.example"
                   value="{{ old('email', $user->email) }}">
            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
        </div>
        <div class="form-group">
            <br>
            <input type="hidden" id="active" value="0" />
            <input type="checkbox" name="active" id="active" value="1"/> Active
            <br>
            <br>
            <input type="hidden" id="admin" value="0" />
            <input type="checkbox" name="admin" id="admin" value="1"/> Admin
        </div>
        <p>
            <button type="submit" id="submit" class="btn btn-success">Save user</button>
        </p>
    </div>
</div>
<script>
    @if($user->active=='1')
        $('#active').prop('checked', true);
        @endif

    @if($user->admin=='1')
        $('#admin').prop('checked', true);
        @endif
</script>

