@include('layouts.partials.header')
<div class="container">
	
	<!-- Success flash message -->
	@include('layouts.flashMessages.success')

	<!-- Warning flash message -->
	@include('layouts.flashMessages.warning')

	<!-- The content -->
	@yield('content')
</div>
@include('layouts.partials.footer')