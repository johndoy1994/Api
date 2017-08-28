@if(Session::has('message'))
    <div class="callout form-group alert {{Session::get('alert-class')}} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p><i class="icon fa {{(Session::get('alert-class') == 'alert-success') ? 'fa-check': 'fa-ban'}}"></i>{{ Session::get('message') }}</p>
    </div>
@endif
@if ($errors->any())
    <div class="callout form-group alert alert-danger alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        @foreach($errors->all() as $error) 
            <li ><i class="icon fa fa-ban"></i>{{ $error }}</li>
        @endforeach 
    </div>
@endif 