<div class="col-lg-6 col-md-12">
	<div class="card px-2">
		<a class="card-image card-img-top round-corners bg-image" href="{{ $highlights->get(0)->article->paths()->route() }}" style="height: 22em;background-image: url({{ $highlights->get(0)->article->paths()->image() }})">
			<span class="badge badge-info btn-theme-green">{{__('global.in')}} {{__('categories.'.$highlights->get(0)->article->category->slug)}}</span>
		</a>
		<div class="card-block px-2 py-3">
			<a class="text-default" href="{{ $highlights->get(0)->article->paths()->route() }}">
				<h4 class="card-title mb-2">{{ $highlights->get(0)->article->title }}</h4>
			</a>
			<p class="card-text text-muted mb-2 l-height-1">{{ $highlights->get(0)->article->description }}</p>
			<small class="d-block">{{__('global.published')}} {{ $highlights->get(0)->article->created_at->toFormattedDateString() }}</small>
			<small>{{__('global.by')}} 
				@foreach ($highlights->get(0)->article->authors as $author)
				{{ $loop->first ? '' : ',' }}
				<a style="margin-right: -2px;" href="{{ $author->paths()->route() }}">{{ $author->resources()->fullName() }}</a>
				@endforeach
				| {{ $highlights->get(0)->article->reading_time }} min {{__('global.read')}}</small>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-12">
		<div class="row no-gutters">
			<div class="col-lg-6 col-md-6 col-xs-12">
				<div class="card px-2">
					<a class="card-image card-img-top round-corners bg-image mobile-default-height" href="{{ $highlights->get(1)->article->paths()->route() }}" style="height: 10em;background-image: url({{ $highlights->get(1)->article->paths()->image() }})">
						<span class="badge badge-info btn-theme-green">{{__('global.in')}} {{__('categories.'.$highlights->get(1)->article->category->slug)}}</span>
					</a>
					<div class="card-block px-2 py-3">
						<a class="text-default" href="{{ $highlights->get(1)->article->paths()->route() }}">
							<h6 class="card-title mb-2 two-line-clamp"><strong>{{ $highlights->get(1)->article->title }}</strong></h6>
						</a>
						<p class="card-text text-muted mb-2 l-height-1 two-line-clamp">{{ $highlights->get(1)->article->description }}</p>
						<small class="d-block">{{ $highlights->get(1)->article->created_at->toFormattedDateString() }} | {{ $highlights->get(1)->article->reading_time }} min {{__('global.read')}}</small>
					</div>
				</div>					
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12">
				<div class="card px-2">
					<a class="card-image card-img-top round-corners bg-image mobile-default-height" href="{{ $highlights->get(2)->article->paths()->route() }}" style="height: 10em;background-image: url({{ $highlights->get(2)->article->paths()->image() }})">
						<span class="badge badge-info btn-theme-green">{{__('global.in')}} {{__('categories.'.$highlights->get(2)->article->category->slug)}}</span>
					</a>
					<div class="card-block px-2 py-3">
						<a class="text-default" href="{{ $highlights->get(2)->article->paths()->route() }}">
							<h6 class="card-title mb-2 two-line-clamp"><strong>{{ $highlights->get(2)->article->title }}</strong></h6>
						</a>
						<p class="card-text text-muted mb-2 l-height-1 two-line-clamp">{{ $highlights->get(2)->article->description }}</p>
						<small class="d-block">{{ $highlights->get(2)->article->created_at->toFormattedDateString() }} | {{ $highlights->get(2)->article->reading_time }} min {{__('global.read')}}</small>
					</div>
				</div>	
			</div>
		</div>
		<div class="row no-gutters">
			<div class="col-lg-5 hidden-md-down">
				<div class="card px-2">
					<a class="card-image card-img-top round-corners bg-image mobile-default-height" href="{{ $highlights->get(3)->article->paths()->route() }}" style="height: 8em;background-image: url({{ $highlights->get(3)->article->paths()->image() }})">
						<span class="badge badge-info btn-theme-green">{{__('global.in')}} {{__('categories.'.$highlights->get(3)->article->category->slug)}}</span>
					</a>
					<div class="card-block px-2 py-3">
						<a class="text-default" href="{{ $highlights->get(3)->article->paths()->route() }}">
							<h6 class="card-title mb-2 two-line-clamp"><strong>{{ $highlights->get(3)->article->title }}</strong></h6>
						</a>
						<p class="card-text text-muted mb-2 l-height-1 one-line-clamp">{{ $highlights->get(3)->article->description }}</p>
						<small class="d-block">{{ $highlights->get(3)->article->created_at->toFormattedDateString() }} | {{ $highlights->get(3)->article->reading_time }} min {{__('global.read')}}</small>
					</div>
				</div>							
			</div>
			<div class="col-lg-7 col-md-12">
				<div class="card px-2 h-auto">
					<div class="card-block">
						<a class="text-default" href="{{ $highlights->get(4)->article->paths()->route() }}">
							<h6 class="card-title mb-2 two-line-clamp l-height-1"><strong>{{ $highlights->get(4)->article->title }}</strong></h6>
						</a>
						<small class="d-block">{{ $highlights->get(4)->article->created_at->toFormattedDateString() }} | {{ $highlights->get(4)->article->reading_time }} min {{__('global.read')}}</small>
					</div>
				</div>
				<hr class="my-2">
				<div class="card px-2 h-auto">
					<div class="card-block">
						<a class="text-default" href="{{ $highlights->get(5)->article->paths()->route() }}">
							<h6 class="card-title mb-2 two-line-clamp l-height-1"><strong>{{ $highlights->get(5)->article->title }}</strong></h6>
						</a>
						<small class="d-block">{{ $highlights->get(5)->article->created_at->toFormattedDateString() }} | {{ $highlights->get(5)->article->reading_time }} min {{__('global.read')}}</small>
					</div>
				</div>	
				<hr class="my-2">
				<div class="card px-2 h-auto">
					<div class="card-block">
						<a class="text-default" href="{{ $highlights->get(6)->article->paths()->route() }}">
							<h6 class="card-title mb-2 two-line-clamp l-height-1"><strong>{{ $highlights->get(6)->article->title }}</strong></h6>
						</a>
						<small class="d-block">{{ $highlights->get(6)->article->created_at->toFormattedDateString() }} | {{ $highlights->get(6)->article->reading_time }} min {{__('global.read')}}</small>
					</div>
				</div>					
			</div>
		</div>
	</div>