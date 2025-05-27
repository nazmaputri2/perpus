@extends('layouts.petugas')

@section('title', 'Data Petugas')

@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
    {{-- modal siswa --}}
    @include('components.datapetugas.modal-tambah-petugas')
    {{-- @include('components.datasiswa.modal-edit-siswa')
    @include('components.datasiswa.modal-hapus-siswa') --}}
@endpush

@section('content')
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <strong>Oops!</strong> Ada kesalahan:
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
    <h3 class="text-2xl font-semibold text-gray-800">Data Petugas</h3>
    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
        <!-- Search Bar -->
        <div class="relative w-full sm:w-64">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-500"></i>
            </div>
            <input type="text" id="search"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                placeholder="Cari petugas...">
        </div>

        <!-- Add Button -->
        <button data-modal-target="tambahDataModal" data-modal-toggle="tambahDataModal" type="button"
            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
            + Tambah
        </button>
    </div>
</div>

<div class="p-4 bg-white rounded-xl shadow-lg mb-6 border border-gray-200">
    <div class="grid grid-cols-1 gap-4 mb-4">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-800 border border-gray-300">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 w-[15%] border-b border-gray-300">NIP</th>
                        <th scope="col" class="px-4 py-3 w-[25%] border-b border-gray-300">Nama</th>
                        <th scope="col" class="px-4 py-3 w-[15%] border-b border-gray-300">No HP</th>
                        <th scope="col" class="px-4 py-3 w-[15%] border-b border-gray-300">Alamat</th>
                        <th scope="col" class="px-4 py-3 w-[30%] text-center border-b border-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($petugas as $staf)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $staf->nip }}</td>
                        <td class="px-4 py-3">{{ $staf->nama }}</td>
                        <td class="px-4 py-3">{{ $staf->nohp }}</td>
                        <td class="px-4 py-3">{{ $staf->alamat }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center space-x-2">
                                <button onclick="prepareEditModal({{ json_encode($staf) }})" 
                                    data-modal-target="editDataModal" data-modal-toggle="editDataModal"
                                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none">
                                    <i class="fas fa-edit mr-1"></i> Ubah
                                </button>
                                <button onclick="setDeleteId({{ $staf->nip }})"
                                    data-modal-target="deleteModal" data-modal-toggle="deleteModal"
                                    class="text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Function to prepare edit modal with student data
    function prepareEditModal(staf) {
        document.getElementById('edit-nip').value = staf.nip;
        document.getElementById('edit-nama').value = staf.nama;
        document.getElementById('edit-nohp').value = staf.nohp;
        document.getElementById('edit-alamat').value = staf.alamat;


         const form = document.getElementById('edit-form');
    form.action = `/petugas/datapetugas/${staf.nip}`;
        const editModal = new Flowbite.Modal(document.getElementById('editDataModal'));
        editModal.show();
    }

    // Function to set student ID for deletion
    function setDeleteId(nip) {
        document.getElementById('delete-form').action = '/petugas/datapetugas/'+ nip;
    }
</script>
@endpush