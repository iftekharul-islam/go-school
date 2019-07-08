<div class="row mb-2 mt-5">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
            <label for="about" class="col-md-4 control-label">About Book</label>

            <div class="col-md-12">
                <textarea rows="3" id="about" type="text" class="form-control" name="about" value="{{ old('about') }}" placeholder="About Book" required></textarea>

                @if ($errors->has('about'))
                    <span class="help-block">
                <strong>{{ $errors->first('about') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            <label for="title" class="col-md-4 control-label">Book Title</label>

            <div class="col-md-12">
                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Book Title" required>

                @if ($errors->has('title'))
                    <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
            <label for="type" class="col-md-4 control-label">Book Type</label>

            <div class="col-md-12">
                <select id="type" class="select2" name="type">
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
            <label for="book_code" class="col-md-4 control-label">Book Code</label>

            <div class="col-md-12">
                <input id="book_code" type="text" class="form-control" name="book_code" value="{{ old('book_code') }}" placeholder="Book Code" required>

                @if ($errors->has('book_code'))
                    <span class="help-block">
                <strong>{{ $errors->first('book_code') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
            <label for="author" class="col-md-4 control-label">Book Author</label>

            <div class="col-md-12">
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
            <label for="price" class="col-md-4 control-label">Book Price</label>

            <div class="col-md-12">
                <input id="price" type="number" class="form-control" name="price" value="{{ old('price') }}" placeholder="Book Price" required>

                @if ($errors->has('price'))
                    <span class="help-block">
                <strong>{{ $errors->first('price') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
            <label for="quantity" class="col-md-4 control-label">Book Quantity</label>

            <div class="col-md-12">
                <input id="quantity" type="number" class="form-control" name="quantity" value="{{ old('quantity') }}" placeholder="Book Quantity" required>

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
            <label for="rackNo" class="col-md-4 control-label">Book Rack Number</label>

            <div class="col-md-12">
                <input id="rackNo" type="number" class="form-control" name="rackNo" value="{{ old('rackNo') }}" placeholder="Book Rack Number" required>

                @if ($errors->has('rackNo'))
                    <span class="help-block">
                <strong>{{ $errors->first('rackNo') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('rowNo') ? ' has-error' : '' }}">
            <label for="rowNo" class="col-md-4 control-label">Book Row Number</label>

            <div class="col-md-12">
                <input id="rowNo" type="number" class="form-control" name="rowNo" value="{{ old('rowNo') }}" placeholder="Book Row Number" required>

                @if ($errors->has('rowNo'))
                    <span class="help-block">
                <strong>{{ $errors->first('rowNo') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('img_path') ? ' has-error' : '' }}">
            <label for="img_path" class="col-md-4 control-label">Book Image URL</label>

            <div class="col-md-12">
                <input id="img_path" type="text" class="form-control" name="img_path" value="{{ old('img_path') }}" placeholder="Book Image Url" required>

                @if ($errors->has('img_path'))
                    <span class="help-block">
                <strong>{{ $errors->first('img_path') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
</div>
