 <option value="all">All</option>
 @foreach ($extensions as $extension)
 <option value="{{$extension->extension_content}}">{{$extension->extension_content}}</option>
 @endforeach
