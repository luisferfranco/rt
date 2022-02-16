@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Users</div>

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          <ul id="users"></ul>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  window.axios.get('/api/users')
    .then((res) => {
      const usersElement = document.getElementById('users')
      let users = res.data
      users.forEach((user, index) => {
        let element=document.createElement('li')

        element.setAttribute('id', user.id)
        element.innerText = user.name

        usersElement.appendChild(element)
      })
    });
</script>

<script>
  const usersElement = document.getElementById('users')

  Echo.channel('users')
    .listen('UserCreated', (e) => {
      let element=document.createElement('li')

      element.setAttribute('id', e.user.id)
      element.innerText = e.user.name

      usersElement.appendChild(element)
    })
    .listen('UserUpdated', (e) => {
      let element = document.getElementById(e.user.id)
      element.innerText = e.user.name
    })
    .listen('UserDeleted', (e) => {
      let element = document.getElementById(e.user.id)
      element.parentNode.removeChild(element)
    })
</script>
@endpush
