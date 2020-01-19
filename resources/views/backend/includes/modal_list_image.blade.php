



<ul class="list-image">
  @foreach ($allImage as $key => $image)
      <li>
          <a class="get_info_iamge" href="javascript:;">
              <img src="{{$image->getUrl('thumb')}}">
              <span></span>
              <h2>{{$image->name}}</h2>
              <p class="info" style="display:none"><?php echo json_encode($image); ?></p>
          </a>
      </li>
  @endforeach
</ul>
<div class="clearfix mt-n1"></div>
{!! $allImage->render() !!}
<div class="cover-loader">
    <div class="loader">Loading...</div>
</div>
