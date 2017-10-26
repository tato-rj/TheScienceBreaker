@extends('admin/_core')

@section('content')
  
    <div class="container-fluid mb-4">
      
      @component('admin/snippets/page_title')
          Managers
        @slot('comment')
          Use the form below to <u>add</u> a new member
        @endslot
      @endcomponent

      <div class="row mt-4">
        <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
          <h2 class="text-muted op-5">
            <i class="fa fa-file-text mr-1" aria-hidden="true"></i> <strong>New member</strong>
          </h2>
          <form method="POST" action="/admin/managers">
            {{csrf_field()}}
            {{-- First Name --}}
            <div class="form-group">
              <input required type="text" value="{{ old('first_name') }}" name="first_name" class="form-control" id="first_name" aria-describedby="first_name" placeholder="First Name">
              {{-- Error --}}
              @component('admin/snippets/error')
                first_name
                @slot('feedback')
                {{ $errors->first('first_name') }}
                @endslot
              @endcomponent
            </div>
            {{-- Last Name --}}
            <div class="form-group">
              <input required type="text" value="{{ old('last_name') }}" name="last_name" class="form-control" id="last_name" aria-describedby="last_name" placeholder="Last Name">
              {{-- Error --}}
              @component('admin/snippets/error')
                last_name
                @slot('feedback')
                {{ $errors->first('last_name') }}
                @endslot
              @endcomponent
            </div>
            {{-- Email --}}
            <div class="form-group">
              <input required type="text" value="{{ old('email') }}" name="email" class="form-control" id="email" aria-describedby="email" placeholder="E-mail">
              {{-- Error --}}
              @component('admin/snippets/error')
                email
                @slot('feedback')
                {{ $errors->first('email') }}
                @endslot
              @endcomponent
            </div>
            {{-- Division --}}
            <div class="form-group">
              <input required type="text" value="{{ old('division') }}" name="division" class="form-control" id="division" aria-describedby="division" placeholder="Division">
              {{-- Error --}}
              @component('admin/snippets/error')
                division
                @slot('feedback')
                {{ $errors->first('division') }}
                @endslot
              @endcomponent
            </div>
            {{-- Position --}}
            <div class="form-group">
              <input required type="text" value="{{ old('position') }}" name="position" class="form-control" id="position" aria-describedby="position" placeholder="Position">
              {{-- Error --}}
              @component('admin/snippets/error')
                position
                @slot('feedback')
                {{ $errors->first('position') }}
                @endslot
              @endcomponent
            </div>
            {{-- Biography --}}
            <div class="form-group">
              <textarea class="form-control" name="biography" id="biography" rows="8" placeholder="Biography">{{ old('biography') }}</textarea>
              {{-- Error --}}
              @component('admin/snippets/error')
                biography
                @slot('feedback')
                {{ $errors->first('biography') }}
                @endslot
              @endcomponent
            </div>
            {{-- Research Institute --}}
            <div class="form-group">
              <input required type="text" value="{{ old('research_institute') }}" name="research_institute" class="form-control" id="research_institute" aria-describedby="research_institute" placeholder="Research Institute">
              {{-- Error --}}
              @component('admin/snippets/error')
                research_institute
                @slot('feedback')
                {{ $errors->first('research_institute') }}
                @endslot
              @endcomponent
            </div>
            {{-- Field Research --}}
            <div class="form-group">
              <input required type="text" value="{{ old('field_research') }}" name="field_research" class="form-control" id="field_research" aria-describedby="field_research" placeholder="Field Research">
              {{-- Error --}}
              @component('admin/snippets/error')
                field_research
                @slot('feedback')
                {{ $errors->first('field_research') }}
                @endslot
              @endcomponent
            </div>
            {{-- Is Editor --}}
            <div class="form-check">
              <label class="form-check-label mb-2">
                <input type="checkbox" value="1" {{ (old('is_editor') == '1') ? 'checked' : '' }} name="is_editor" class="form-check-input" id="is_editor">
                Is this member also an editor?
              </label>
              {{-- Error --}}
              @component('admin/snippets/error')
                is_editor
                @slot('feedback')
                {{ $errors->first('is_editor') }}
                @endslot
              @endcomponent
            </div>
            <button type="submit" class="btn btn-theme-orange">Submit</button>
          </form>
        </div>
      </div>
    </div>
@endsection