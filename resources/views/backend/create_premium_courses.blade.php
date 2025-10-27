@extends('backend.app')

@section('content')

<div class="container">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add courses</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{route('admin.courses.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
              <div class="card-body">

                <div class="form-group">
                    <label for="exampleInputFile">Type</label>
                <select class="form-select form-select-lg mb-3 form-control" aria-label=".form-select-lg example" name="type">
                    <option selected>Open this select menu</option>

                    <option value="single">Single</option>
                    <option value="bundle">Bundle</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                    <option value="lifetime">Life Time</option>
                    <option value="weekly">Weekly</option>
                    <option value="free">Free</option>



                  </select>
                </div>

                 <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" required oninput="generateSlug()">
    </div>

    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control" readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Meta Image</label>
        <input type="file" name="meta_image" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Meta Title</label>
        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="Meta title for SEO">
    </div>

    <div class="mb-3">
        <label class="form-label">Meta Description</label>
        <textarea name="meta_description" class="form-control" rows="3" placeholder="Short description for search engines">{{ old('meta_description') }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Author</label>
        <input type="text" name="author" class="form-control" value="{{ old('author') }}" placeholder="Author name">
    </div>

    <div class="mb-3">
        <label class="form-label">Publisher</label>
        <input type="text" name="publisher" class="form-control" value="{{ old('publisher') }}" placeholder="Publisher name">
    </div>

    <div class="mb-3">
        <label class="form-label">Copyright</label>
        <input type="text" name="copyright" class="form-control" value="{{ old('copyright') }}" placeholder="Copyright notice">
    </div>

    <div class="mb-3">
        <label class="form-label">Site Name</label>
        <input type="text" name="site_name" class="form-control" value="{{ old('site_name') }}" placeholder="Site name for structured data">
    </div>

    <div class="mb-3">
        <label class="form-label">Keywords</label>
        <input type="text" name="keywords" class="form-control" value="{{ old('keywords') }}" placeholder="Keyword1, Keyword2, Keyword3">
    </div>

    <div class="mb-3">
        <label class="form-label">Instructor</label>
        <input type="text" name="instructor" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Duration</label>
        <input type="text" name="duration" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Effort</label>
        <input type="text" name="effort" class="form-control">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Questions</label>
        <input type="text" name="questions" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Format</label>
        <input type="text" name="format" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" name="price" step="0.01" class="form-control">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Old Price</label>
        <input type="number" name="old_price" step="0.01" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Link</label>
        <input type="text" name="link" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label ">Short Description</label>
        <textarea name="short_description" class="form-control textarea"></textarea>
    </div>

    

    <div class="mb-3">
        <label class="form-label">Long Description</label>
        <textarea name="long_description" class="form-control textarea"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="1" selected>Active</option>
            <option value="0">Inactive</option>
        </select>

                
                


              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
    </div>
</div>

<script>
function generateSlug() {
    let title = document.getElementById("title").value;
    let slug = title.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
    document.getElementById("slug").value = slug;
}
</script>

@endsection
