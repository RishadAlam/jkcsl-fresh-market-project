<div class="col-md-6">
    <div class="form-group">
        <label class="small mb-1" for="inputname">{{$label}} {{$require}}</label>
        <input class="form-control py-4 " id="{{$id}}" type="{{$type}}" placeholder="{{$placeholder}}" name="{{$name}}" value="{{$value}}" {{$required}} autocomplete="{{$name}}" autofocus />
        {{-- @error({{$error}})
            <span class="text-danger">{{$message}}</span>
        @enderror --}}
    </div>
</div>