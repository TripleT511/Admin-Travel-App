@extends('layouts.admin')

@section('title','Thêm địa danh')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Thêm địa danh</h4>
                @if($errors->any()) 
                    @foreach ($errors->all() as $err)
                        <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                    @endforeach
                @endif
            <hr>
            <form class="forms-sample" action="{{ route('diaDanh.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName1">Tên địa danh</label>
                     <input type="text" class="form-control text-light"  name="tenDiaDanh" placeholder="Tên địa danh">
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Mô tả</label>
                    <textarea name="moTa" class="form-control text-light editor" placeholder="Mô tả"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Vĩ độ</label>
                     <input type="text" class="form-control text-light" name="viDo" placeholder="Vĩ độ">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Kinh độ</label>
                    <input type="text" class="form-control text-light" name="kinhDo" placeholder="Kinh độ">
                </div>
                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input type="file" name="hinhAnh[]" class="file-upload-default" multiple>
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" placeholder="Upload Image">
                        <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">Upload hình ảnh</button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Tỉnh thành</label>
                    <select class="form-control text-light" name="idTinhThanh">
                        @foreach ($lstTinhThanh as $item)
                            <option value="{{ $item->id }}">
                             {{ $item->tenTinhThanh}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Nhu cầu</label>
                    <select class="form-control text-light" name="idNhuCau[]" multiple>
                         @foreach($lstNhuCau as $nc)
                            <option value="{{$nc->id}}">{{$nc->tenNhuCau}}</option>
                         @endforeach
                     </select>
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
        $(document).ready(function() {

            ClassicEditor.create(document.querySelector('.editor'), {

                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'outdent',
                        'indent',
                        '|',
                        'undo',
                        'redo',
                        'alignment',
                        'fontBackgroundColor',
                        'fontColor',
                        'fontFamily',
                        'fontSize',
                        'imageInsert',
                        'imageUpload'
                    ]
                },
                language: 'vi',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side',
                        'linkImage'
                    ]
                },
                licenseKey: '',


            }).then(editor => {
                window.editor = editor;

            }).catch(error => {
                console.error('Oops, something went wrong!');
                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                console.warn('Build id: vfyda13refdk-szi4hnq4duwz');
                console.error(error);
            });
        });
    </script>

@endsection