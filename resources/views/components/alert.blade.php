@php
    $type="";
    $error="";
    $msg="";

@endphp

<script>
function demo3(msg,cl="#2e344e"){
    const notification3 = new Notification({
    text: msg,
    showProgress: true,
    style: {
      background: cl,
      color: '#ffffff',
      transition: 'all 350ms linear',
      height:'100%'
    },
  });
  }
</script>



@if ($message = Session::get('success'))
@php
    Session::forget('error');

@endphp

    <script>
        demo3('{{$message}}');
    	// toastr["success"]("{{ $message }}")
    </script>
@endif

@if ($message = Session::get('error'))
    @php
    Session::forget('success');

    @endphp
    <script>
    	// toastr["error"]("{{ $message }}")
        demo3('{{$message}}');

    </script>
@endif

@if ($message = Session::get('warning'))
    <script>
    	// toastr["warning"]("{{ $message }}")
        demo3('{{ $message }}');

    </script>
@endif

@if ($message = Session::get('info'))
    <script>
    	// toastr["info"]("{{ $message }}")
        demo3('{{$message}}');

    </script>
@endif

@if ($errors->any())
	<script>
                demo3('Please check the form for errors');

        
    	// toastr["error"]("Please check the form for errors")
    </script>
@endif


@php
    Session::forget('error');

@endphp



<script>

    function ajax_message(msg,error=""){

        if(!error)
        {
            demo3(msg);
        }else{
           // console.log(error);
            $.each(error, function (key, val) {
                demo3(val);
            });

        }
    }
</script>
 

{{-- @if ($errors->any())
	@foreach($errors as $key => $error)
        
    @endforeach
    @php
    $msg = $error;
    $type="info";
     @endphp
@endif --}}



