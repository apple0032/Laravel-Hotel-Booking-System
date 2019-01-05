@if (Session::has('success'))
	
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Success : </strong> {{ Session::get('success') }}
	</div>

@endif

@if (Session::has('danger'))

	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Danger : </strong> {{ Session::get('danger') }}
	</div>

@endif

@if (count($errors) > 0)

	<div class="alert alert-danger" role="alert">
		<strong>Errors:</strong>
		<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach  
		</ul>
	</div>


@endif

<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 2000);
</script>