<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="name" class="form-label ">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name='name' value="{{ old('name', $category->name) }}" placeholder="Category Name">
        @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>
<div class="mb-4">
    <label style="color:black" for="description" class="form-label ">description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
    @error('description')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="mb-4">
    <label style="color:black" for="image_path" class="form-label ">Image</label><br>
    @if($category->image_path)
    <img src="{{ asset('storage/' . $category->image_path) }}" width="100" alt="">
    @endif
    <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name='image_path' >
    @error('image_path')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="mb-4">
    <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror" aria-label=".form-select-lg parentId">
        @foreach($parents as $parent)
        <option value="{{ $parent->id }}" @if($category->parent_id == $parent->id) selected @endif >{{ $parent->name }}</option>
        @endforeach
    </select>
    @error('parent_id')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<div style="margin-top:1.5em; margin-bottom:1.5em;">
    <h5 style="color:black">Status</h5>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value='active' id="status-active" @if($category->status == 'active') checked @endif>
        <label class="form-check-label" for="status-active">
            Active
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value='inactive' id="status-inactive" @if($category->status == 'inactive') checked @endif>
        <label class="form-check-label" for="status-draft">
            In Active
        </label>
    </div>
    @error('status')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<button type="submit" class="btn btn-primary">{{$button}}</button>