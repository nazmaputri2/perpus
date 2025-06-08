@extends('layouts.petugas')

@section('title', 'Data Siswa')

@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
    {{-- modal siswa --}}
    @include('components.datasiswa.modal-tambah-siswa')
    @include('components.datasiswa.modal-edit-siswa')
    @include('components.datasiswa.modal-hapus-siswa')
@endpush

@section('content')
@if ($errors->any())
    <div class="bg-gradient-to-r from-red-100 to-red-50 dark:from-red-900 dark:to-red-800 text-red-800 dark:text-red-100 p-6 rounded-2xl shadow-xl mb-10 border border-red-200 dark:border-red-700" role="alert">
        <div class="flex items-center mb-3">
            <i class="fas fa-exclamation-circle text-red-500 dark:text-red-400 mr-3 text-2xl animate-pulse"></i>
            <strong class="font-extrabold text-2xl tracking-wide">Peringatan!</strong>
        </div>
        <ul class="list-disc list-inside space-y-2 text-base">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-6">
    <h3 class="text-5xl font-extrabold text-gray-900 dark:text-white tracking-tight leading-tight">Manajemen Siswa</h3>
    <div class="flex flex-col sm:flex-row gap-5 w-full sm:w-auto">
        <div class="relative w-full sm:w-80 group">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors duration-300">
                <i class="fas fa-search text-xl"></i>
            </div>
            <input type="text" id="search"
                class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-lg rounded-full focus:ring-blue-500 focus:border-blue-500 block w-full pl-14 pr-6 py-3 shadow-md group-focus-within:shadow-lg transition-all duration-300 ease-in-out placeholder-gray-400 dark:placeholder-gray-500"
                placeholder="Cari NIS atau nama...">
        </div>

        <button data-modal-target="tambahDataModal" data-modal-toggle="tambahDataModal" type="button"
            class="inline-flex items-center justify-center text-white bg-gradient-to-br from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 focus:ring-4 focus:ring-green-300 font-bold rounded-full text-lg px-8 py-3 shadow-xl transform hover:scale-105 active:scale-95 transition-all duration-300 ease-in-out dark:focus:ring-green-800">
            <i class="fas fa-plus-circle mr-3 text-xl"></i> Tambah Data Baru
        </button>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="w-full overflow-x-auto">
        <table class="w-full text-base text-left text-gray-800 dark:text-gray-200">
            <thead class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-600">
                <tr>
                    <th scope="col" class="px-8 py-5">NIS</th>
                    <th scope="col" class="px-8 py-5">Nama Lengkap</th>
                    <th scope="col" class="px-8 py-5">Jenis Kelamin</th>
                    <th scope="col" class="px-8 py-5">Kelas</th>
                    <th scope="col" class="px-8 py-5">No. Telepon</th>
                    <th scope="col" class="px-8 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr class="bg-white dark:bg-gray-800 border-b last:border-b-0 border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 ease-in-out group">
                    <td class="px-8 py-5 font-semibold text-gray-900 dark:text-white whitespace-nowrap group-hover:text-blue-600 dark:group-hover:text-blue-300 transition-colors duration-200">{{ $student->nis_siswa }}</td>
                    <td class="px-8 py-5">{{ $student->nama_siswa }}</td>
                    <td class="px-8 py-5">{{ $student->kelamin_siswa }}</td>
                    <td class="px-8 py-5">{{ $student->kelas_siswa }}</td>
                    <td class="px-8 py-5">{{ $student->nohp_siswa }}</td>
                    <td class="px-8 py-5">
                        <div class="flex justify-center space-x-4">
                            <button onclick="prepareEditModal({{ json_encode($student) }})"
                                data-modal-target="editDataModal" data-modal-toggle="editDataModal"
                                class="inline-flex items-center text-white bg-gradient-to-br from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 shadow-md transform hover:scale-105 active:scale-95 transition-all duration-200 ease-in-out focus:outline-none dark:focus:ring-blue-800">
                                <i class="fas fa-pencil-alt mr-2"></i> Edit
                            </button>
                            <button onclick="setDeleteId({{ $student->nis_siswa }})"
                                data-modal-target="deleteModal" data-modal-toggle="deleteModal"
                                class="inline-flex items-center text-white bg-gradient-to-br from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 shadow-md transform hover:scale-105 active:scale-95 transition-all duration-200 ease-in-out focus:outline-none dark:focus:ring-red-800">
                                <i class="fas fa-trash-alt mr-2"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-10 text-center text-gray-500 dark:text-gray-400 text-xl font-medium">
                            <i class="fas fa-info-circle mr-2 text-2xl"></i> Belum ada data siswa. Silakan tambahkan!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Function to prepare edit modal with student data
    function prepareEditModal(student) {
        document.getElementById('edit-nis_siswa').value = student.nis_siswa;
        document.getElementById('edit-nama_siswa').value = student.nama_siswa;
        document.getElementById('edit-kelamin_siswa').value = student.kelamin_siswa;
        document.getElementById('edit-kelas_siswa').value = student.kelas_siswa;
        document.getElementById('edit-nohp_siswa').value = student.nohp_siswa;


         const form = document.getElementById('edit-form');
    form.action = `/petugas/datasiswa/${student.nis_siswa}`;
        const editModal = new Flowbite.Modal(document.getElementById('editDataModal'));
        editModal.show();
    }

    // Function to set student ID for deletion
    function setDeleteId(nis_siswa) {
        document.getElementById('delete-form').action = '/petugas/datasiswa/'+ nis_siswa;
    }
</script>
@endpush