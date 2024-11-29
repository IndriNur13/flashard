@extends('layout.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h3 class="m-0 font-weight-bold text-primary">Data Flashcard</h3>
        <a href="/flashcard" class="btn btn-primary mb-4 mt-4">Tambah Data Flashcard</a>
        <div class="row">
            <div class="col-12">
            <div class="table-responsive">
                <table id="example" class="display expandable-table" style="width:100%">
                <thead>
                    <tr>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Front Content</th>
                    <th>Back Content</th>
                    <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataflashcard as $item)
                    <tr>
                        <td>{{$item->category->category_name ?? 'No Category' }}</td> <!-- Tampilkan nama kategori -->
                        <td>{{$item->title}}</td>
                        <td>{{$item->front_content}}</td>
                        <td>{{$item->back_content}}</td>
                        <td>
                            <a href="/flashcard/table/edit/{{$item->id}}" class="btn btn-sm btn-warning mdi mdi-pencil text-white"></a>
                            <a href="/flashcard/table/hapus/{{$item->id}}" class="btn btn-sm btn-danger mdi mdi-delete text-white"></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
