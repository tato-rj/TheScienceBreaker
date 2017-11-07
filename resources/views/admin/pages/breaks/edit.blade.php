@extends('admin/_core')

@section('content')
  
    <div class="container-fluid mb-4">
      
      @component('admin/snippets/page_title')
          Breaks
        @slot('comment')
          Use the form below to <u>edit</u> the Break
        @endslot
      @endcomponent

      <div class="row mt-4">
        <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
          <h2 class="text-muted op-5 mb-3">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <strong>Edit Break</strong>
          </h2>
          <div class="form-group">
            <label for="exampleSelect2">Select the Break to be edited</label>
            <select class="form-control" id="break_id" name="break_id">
              <option selected disabled>I want to edit...</option>
              @foreach ($breaks as $break)
              <option data-slug="{{ $break->slug }}">{{ $break->title }}</option>
              @endforeach
            </select>
          </div>
          <form method="POST" action="/admin/breaks/{{ $article->slug }}" enctype="multipart/form-data">
            {{csrf_field()}}
            {{method_field('PATCH')}}
            {{-- Title --}}
            
              <div class="form-group">
                <label><strong>Title</strong></label>
                <div class="d-flex align-items-center">
                  <input required type="text" value="{{ $article->title }}" name="title" class="form-control" id="title" aria-describedby="title" placeholder="Title">
                  <button type="button" class="btn btn-theme-green ml-2" data-toggle="modal" data-target="#tags">Tags</button>               
                </div>

                {{-- Error --}}
                @component('admin/snippets/error')
                  title
                  @slot('feedback')
                  {{ $errors->first('title') }}
                  @endslot
                @endcomponent
              </div>
            
            {{-- Content --}}
            <div class="form-group">
              <label><strong>Content</strong></label>
              <textarea required class="form-control" name="content" id="content" rows="22" placeholder="Break">{{ $article->content }}</textarea>
              {{-- Error --}}
              @component('admin/snippets/error')
                content
                @slot('feedback')
                {{ $errors->first('content') }}
                @endslot
              @endcomponent
            </div>
            <div class="form-group">
              <div class=" mb-1 d-flex align-items-center justify-content-between">
                <label><strong>Breakers</strong><span class="badge badge-warning ml-1">{{ count($article->authors) }}</span> <small>(you can select have as many as you need)</small></label>
                <button type="button" id="sort_breakers" class="btn btn-sm btn-theme-orange" data-toggle="modal" data-target="#order_breakers">Order</button>
              </div>
              @include('admin/snippets/order_breakers')
              <select required multiple class="form-control" size="12" id="authors" data-break-slug="{{ $article->slug }}" name="authors[]">
                @foreach ($authors as $author)
                  <option value="{{ $author->id }}" data-sort="{{ $author->orderIn($article) }}" {{ in_array($author->id, $article->authorsIds()) ? 'selected' : '' }}>{{ $author->fullName() }}
                  </option>
                @endforeach
              </select>
            </div>
            {{-- Original Article --}}
            <div class="form-group">
              <label><strong>Original Article</strong></label>
              <input required type="text" value="{{ $article->original_article }}" name="original_article" class="form-control" id="original_article" aria-describedby="original_article" placeholder="Original article">
              {{-- Error --}}
              @component('admin/snippets/error')
                original_article
                @slot('feedback')
                {{ $errors->first('original_article') }}
                @endslot
              @endcomponent
            </div>
            <hr>
            <div class="form-inline form-group">
              {{-- Reading Time --}}
              <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                <div class="input-group-addon"><i class="fa fa-hourglass-half" aria-hidden="true"></i></div>
                <input required type="text" value="{{ $article->reading_time }}" name="reading_time" size="10" class="form-control" id="reading_time" placeholder="Reading time">
              </div>
              {{-- Category --}}
              <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="category_id" name="category_id">
                <option  selected disabled>Category</option>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}" {{ ($article->category_id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
              </select>
              {{-- Editor --}}
              <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="editor_id" name="editor_id">
                <option  selected disabled>Editor</option>
                @foreach ($editors as $editor)
                  <option value="{{ $editor->id }}" {{ ($article->editor_id == $editor->id) ? 'selected' : '' }}>{{ $editor->fullName() }}</option>
                @endforeach
              </select>
              <div class="d-block">
                {{-- Errors --}}
                @component('admin/snippets/error')
                  reading_time
                  @slot('feedback')
                  {{ $errors->first('reading_time') }}
                  @endslot
                @endcomponent
                @component('admin/snippets/error')
                  category_id
                  @slot('feedback')
                  {{ $errors->first('category_id') }}
                  @endslot
                @endcomponent
                @component('admin/snippets/error')
                  editor_id
                  @slot('feedback')
                  {{ $errors->first('editor_id') }}
                  @endslot
                @endcomponent
              </div>
            </div>
            <hr>
            {{-- PDF --}}
            <div class="form-group">
              <label class="custom-file">
                <input type="file" id="file" name="file" class="custom-file-input">
                <span class="custom-file-control"></span>
              </label>
              <small class="form-text text-muted">Use this option to upload a PDF file for this break</small>
              {{-- Error --}}
              @component('admin/snippets/error')
                file
                @slot('feedback')
                {{ $errors->first('file') }}
                @endslot
              @endcomponent
            </div>
            {{-- Editor's Pick --}}
            <div class="form-check">
              <label class="form-check-label mb-2">
                <input type="checkbox" value="1" {{ ($article->editor_pick == '1') ? 'checked' : '' }} name="editor_pick" class="form-check-input" id="editor_pick">
                Editor's Pick
              </label>
              {{-- Error --}}
              @component('admin/snippets/error')
                editor_pick
                @slot('feedback')
                {{ $errors->first('editor_pick') }}
                @endslot
              @endcomponent
            </div>
            <button type="submit" class="btn btn-theme-orange">Submit</button>
          </form>
        </div>
      </div>
    </div>
    @include('admin/snippets/tags')
@endsection

@section('scripts')
<script type="text/javascript">
$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

var list = document.getElementById('breakers_list');
var sortable = Sortable.create(list);

$('#sort_breakers').on('click', function() {
  // Reset list and array
  $('#breakers_list').html('');
  $html = [];

  // Get selected authors and put them into an array
  $('#authors option:selected').each(function() {
    $html.push('<li id="'+$(this).val()+'" class="list-none m-1 p-1 px-2" data-sort="'+$(this).attr('data-sort')+'">'+$(this).text()+'</li>');
  });
  // Put the array inside a temp hidden div
  $('#temp_list').append($html);

  // Sort the div based on the data-sort value and put the list on the final div
  $('#temp_list li').sort(function(a,b) {
    return +a.dataset.sort - +b.dataset.sort;
  }).appendTo('#breakers_list');

  // Reset temp div
  $('#temp_list').html('');
  
});

$('#setOrder').on('click', function() {
  var $break_slug = $('#authors').attr('data-break-slug');
  var array = [];
  $('#breakers_list li').each(function() {
    array.push($(this).attr('id'));
  });

  $.post('/admin/breaks/'+$break_slug+'/breakers-order', {'order': array})
  .done(function(msg){
    $('.modal #success small span').text('Order updated!');
    $('.modal #success').fadeIn().delay(1000).fadeOut('fast');
    $('#breakers_list li').each(function(index) {
      $('#authors option[value='+$(this).attr('id')+']').attr('data-sort', index);
    });
    
  })
  .fail(function(xhr, status, error) {
    $('.modal #fail small span').text('Something went wrong...');
    $('.modal #fail').fadeIn().delay(1000).fadeOut('fast');
  });

})



$(document).on('click', '.tags span a', function() {
  $(this).parent().toggleClass('selected');
});

$('#setTags').on('click', function() {
  var tags = [];
  $break_slug = $(this).attr('data-break-slug');

  $('.tags .selected').each(function() {
    tags.push($(this).attr('data-id'));
  });

  $.post('/admin/breaks/'+$break_slug+'/tags', {'tags[]': tags})
  .done(function(msg){
    $('.modal #success small span').text('The tags were updated!');
    $('.modal #success').fadeIn().delay(1000).fadeOut('fast');
  })
  .fail(function(xhr, status, error) {
    $('.modal #fail small span').text('Something went wrong...');
    $('.modal #fail').fadeIn().delay(1000).fadeOut('fast');
  });
});

$('#addTag').on('click', function() {
  $tag = $('input[name="tag"]').val();

  $.post('/admin/tags', {'tag': $tag})
  .done(function(id){
    $('.modal #success small span').text('The tags was created!');
    $('.modal #success').fadeIn().delay(1000).fadeOut('fast');
    $new_tag = $('.tags span').first().clone().removeClass('selected').attr('data-id', id).children('a').text($tag).parent();
    $new_tag.appendTo('.tags');
  })
  .fail(function(xhr, status, error) {
    $('.modal #fail small span').text('Something went wrong...');
    $('.modal #fail').fadeIn().delay(1000).fadeOut('fast');
  });
});

$(document).on('click', '.removeTag', function() {
  $tag = $(this).parent();
  $tag_name = $tag.find('a').text();

  $.post('/admin/tags/'+$tag_name, {_method: 'DELETE'})
  .done(function(id){
    $('.modal #success small span').text('The tags was removed!');
    $('.modal #success').fadeIn().delay(1000).fadeOut('fast');
    $tag.fadeOut();
  })
  .fail(function(xhr, status, error) {
    $('.modal #fail small span').text('Something went wrong...');
    $('.modal #fail').fadeIn().delay(1000).fadeOut('fast');
  });
});

$('select#break_id').on('change', function() {
  $title = this.value;
  $slug = $(this).children(':selected').attr('data-slug');
  window.location.href = '/admin/breaks/'+$slug+'/edit';
});

</script>
@endsection