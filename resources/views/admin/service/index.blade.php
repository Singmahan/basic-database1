<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello... {{ Auth::user()->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if (session("success"))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-header text-white bg-primary">ตารางข้อมูลบริการ</div>

                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">ภาพประกอบ</th>
                                <th scope="col">ชื่อบริการ</th>
                                <th scope="col">วันที่บันทึกข้อมูล</th>
                                <th scope="col">แก้ไขข้อมูล</th>
                                <th scope="col">ลบข้อมูลชั่วคราว</th>
                              </tr>
                            </thead>
                            <tbody>
                                {{-- @php($i=1) --}}
                                @foreach ($services as $row)
                                <tr>
                                    {{-- <th>{{ $i++ }}</th> --}}
                                    <th>{{ $services->firstItem() + $loop->index  }}</th>
                                    <td>
                                        {{-- <img src="{{asset($row->service_image)}}" alt="" width="100" height="100"/> --}}
                                        <img src="image/services/'.$row->service_image.'" width="50" class="img-thumnail rounded-circle">
                                    </td>
                                    <td>{{ $row->service_name }}</td>
                                    <td>
                                        @if ($row->created_at == NULL)
                                            ไม่ถูกนิยาม
                                        @else
                                            {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <a href="{{ url('/departments/edit/'.$row->id) }}" class="btn btn-success btn-sm">แก้ไขข้อมูล</a> --}}
                                    </td>
                                    <td>
                                        {{-- <a href="{{ url('/departments/softdelete/'.$row->id) }}" class="btn btn-danger btn-sm">ลบข้อมูลชั่วคราว</a> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                          {{ $services->links() }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-white bg-primary">แบบฟอร์มเพิ่มข้อมูลบริการ</div>
                        <div class="card-body">
                            <form action="{{ route('addService') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- service_name --}}
                                <div class="form-group">
                                    <label for="service_name">ชื่อบริการ</label>
                                    <input type="text" class="form-control" name="service_name">
                                </div>
                                @error('service_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror

                                {{-- service_image  --}}
                                <div class="form-group">
                                    <label for="service_image">ภาพประกอบ</label>
                                    <input type="file" class="form-control" name="service_image">
                                </div>
                                @error('service_image')
                                    <div class="my-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror

                                <div class="form-group mt-3">
                                    <input type="submit" class="form-control btn btn-success" value="บันทึกข้อมูล">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
