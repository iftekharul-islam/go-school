<div class="row mb-2 mt-5">
    <div class="col-md-12 col-lg-6">
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            <div class="">
                <label for="title" class="control-label">{{ __('text.book_title') }}<label class="text-danger">*</label></label>
                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Book Title" required>

                @if ($errors->has('title'))
                    <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">

            <div class="">
                <label for="about" class="control-label">{{ __('text.about_book') }}</label>
                <textarea rows="3" id="about" type="text" class="form-control" name="about" value="{{ old('about') }}" placeholder="About Book" ></textarea>

                @if ($errors->has('about'))
                    <span class="help-block">
                <strong>{{ $errors->first('about') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
            <div class="">
                <label for="type" class="control-label">{{ __('text.book_type') }}</label>
                <select id="type" class="select2 book-type" name="type">
                    <option value="" disabled selected>Select Book Type</option>
                    <option value="Academic">Academic</option>
                    <option value="Magazine">Magazine</option>
                    <option value="Story">Story</option>
                    <option value="Other">Other</option>
                </select>

                @if ($errors->has('type'))
                    <span class="help-block">
                <strong>{{ $errors->first('type') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('book_code') ? ' has-error' : '' }}">
            <div class="">
                <label for="book_code" class="control-label">{{ __('text.book_code') }}</label>
                <input id="book_code" type="text" class="form-control" name="book_code" value="{{ old('book_code') }}" placeholder="Book Code">

                @if ($errors->has('book_code'))
                    <span class="help-block">
                <strong>{{ $errors->first('book_code') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
            <div class="">
                <label for="author" class="control-label">{{ __('text.author') }}<label class="text-danger">*</label></label>

                <input id="author" type="text" class="form-control" name="author" value="{{ old('author') }}" placeholder="Book Author" required>

                @if ($errors->has('author'))
                    <span class="help-block">
                <strong>{{ $errors->first('author') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
            <div class="">
                <label for="price" class=" control-label">{{ __('text.book_price') }}</label>
                <input id="price" type="number" class="form-control" name="price" value="{{ old('price') }}" placeholder="Book Price">

                @if ($errors->has('price'))
                    <span class="help-block">
                <strong>{{ $errors->first('price') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">


            <div class="">
                <label for="quantity" class="control-label">{{ __('text.quantity') }}</label>
                <input id="quantity" type="number" class="form-control" name="quantity" value="{{ old('quantity') }}" placeholder="Book Quantity">

                @if ($errors->has('quantity'))
                    <span class="help-block">
                <strong>{{ $errors->first('quantity') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('rackNo') ? ' has-error' : '' }}">

            <div class="">
                <label for="rackNo" class=" control-label">{{ __('text.book_rack_number') }}</label>
                <input id="rackNo" type="number" class="form-control" name="rackNo" value="{{ old('rackNo') }}" placeholder="Book Rack Number">

                @if ($errors->has('rackNo'))
                    <span class="help-block">
                <strong>{{ $errors->first('rackNo') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('rowNo') ? ' has-error' : '' }}">
            <div class="">
                <label for="rowNo" class="control-label">{{ __('text.book_row_number') }}</label>
                <input id="rowNo" type="number" class="form-control" name="rowNo" value="{{ old('rowNo') }}" placeholder="Book Row Number">

                @if ($errors->has('rowNo'))
                    <span class="help-block">
                <strong>{{ $errors->first('rowNo') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="false-padding-bottom-form form-group{{ $errors->has('img_path') ? ' has-error' : '' }}">
                <label class="control-label">
                    {{ __('text.upload_picture') }}
                </label>
                <br>
                <input type="file" id="picPath" name="img_path">
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6 form-group for-class" style="display: none;">
        <div class="">
            <label>For Class</label>
            <select class="select2 for-class" id="for_class" name="class_id">
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->class_number }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("select.book-type").change(function(){
            var bookType = $(this).children("option:selected").val();
            if (bookType === 'Academic') {
                $('.for-class').css('display', 'block');
            } else {
                $('.for-class').css('display', 'none');
            }
        });
    });
</script>
