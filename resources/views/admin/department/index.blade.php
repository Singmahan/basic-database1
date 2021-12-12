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
                        <div class="card-header text-white bg-primary">ตารางข้อมูลแผนก</div>

                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">ชื่อแผนก</th>
                                <th scope="col">User ID ที่บันทึกข้อมูล</th>
                                <th scope="col">วันที่บันทึกข้อมูล</th>
                                <th scope="col">แก้ไขข้อมูล</th>
                                <th scope="col">ลบข้อมูลชั่วคราว</th>
                              </tr>
                            </thead>
                            <tbody>
                                {{-- @php($i=1) --}}
                                @foreach ($departments as $row)
                                <tr>
                                    {{-- <th>{{ $i++ }}</th> --}}
                                    <th>{{ $departments->firstItem() + $loop->index  }}</th>
                                    <td>{{ $row->department_name }}</td>
                                    {{-- แบบ join table แล้ว  --}}
                                    {{-- <td>{{ $row->name }}</td> --}}

                                    {{-- แบบ Eloquent --}}
                                    <td>{{ $row->user->name }}</td>
                                    <td>
                                        @if ($row->created_at == NULL)
                                            ไม่ถูกนิยาม
                                        @else
                                            {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('/departments/edit/'.$row->id) }}" class="btn btn-success btn-sm">แก้ไขข้อมูล</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('/departments/softdelete/'.$row->id) }}" class="btn btn-danger btn-sm">ลบข้อมูลชั่วคราว</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                          {{ $departments->links() }}
                    </div>

                        @if (count($trashDepartments) > 0)
                        <div class="card my-2">
                            <div class="card-header text-white bg-primary">เก็บข้อมูล ลบข้อมูลชั่วคราว</div>
                            <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ชื่อแผนก</th>
                                    <th scope="col">User ID ที่บันทึกข้อมูล</th>
                                    <th scope="col">วันที่บันทึกข้อมูล</th>
                                    <th scope="col">กู้คืนข้อมูล</th>
                                    <th scope="col">ลบข้อมูลถาวร</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    {{-- @php($i=1) --}}
                                    @foreach ($trashDepartments as $row)
                                    <tr>
                                        {{-- <th>{{ $i++ }}</th> --}}
                                        <th>{{ $trashDepartments->firstItem() + $loop->index  }}</th>
                                        <td>{{ $row->department_name }}</td>
                                        {{-- แบบ join table แล้ว  --}}
                                        {{-- <td>{{ $row->name }}</td> --}}

                                        {{-- แบบ Eloquent --}}
                                        <td>{{ $row->user->name }}</td>
                                        <td>
                                            @if ($row->created_at == NULL)
                                                ไม่ถูกนิยาม
                                            @else
                                                {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('/departments/restore/'.$row->id) }}" class="btn btn-primary btn-sm">กู้คืนข้อมูล</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('/departments/delete/'.$row->id) }}" class="btn btn-danger btn-sm">ลบข้อมูลถาวร</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                              </table>
                              {{ $trashDepartments->links() }}
                        </div>
                        @endif

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-white bg-primary">แบบฟอร์มเพิ่มข้อมูล</div>
                        <div class="card-body">
                            <form action="{{ route('addDepartment') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">ชื่อแผนก</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>
                                @error('department_name')
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
