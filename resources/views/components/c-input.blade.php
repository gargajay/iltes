        <div class="form-group ">
            @php
                $inputLabel = $label ? $label:$name;
            @endphp
        <label class="custom_label" for="{{$inputLabel}}">{{ucwords(str_replace('_', ' ', $inputLabel))}}</label>
    @if($type=='password')

        
        <input type="{{$type}}" name="{{$name}}"  class="custom_input {{$class}}  @error('{{$name}}') error @enderror" id="{{$id}}" placeholder="{{$placeHolder}}">

    @elseif($type=='select')  

        
        <select class="custom_input" id="{{$name}}" name="{{$name}}" data-placeholder="Select a option" required>
            @forelse($option as $key2 => $value2)
                <option value="{{$key2}}" @if($key2==$value)
                    selected
                @endif>{{$key2}}-{{$value2}}</option>
            @empty
                
            @endforelse
         
        </select>
    @elseif($type=='textarea')  
    <textarea name="{{$name}}" id="mytextarea1" class="custom_input {{$class}}  @error('{{$name}}') error @enderror">{{old($name,$value)}}</textarea>

    @else


      <input type="{{$type}}"  name="{{$name}}" value="{{old($name,$value)}}"  class="custom_input {{$class}}  @error('{{$name}}') error @enderror" id="{{$id}}" placeholder="{{$placeHolder}}">

    @endif

    <span class="invalid">
        @if($errors->has($name))
            {{ $errorMsg ? $errorMsg:$errors->first($name) }}
        @endif
    </span>
</div>

{{-- <label class="custom_label">Name</label>
<input type="text" class="custom_input" placeholder="Product Name" name=""> --}}
