<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //ambil data dr key search_nama bagian paramsnya postman
        $search = $request->search_nama;

        //ambil data dari key limit bagian paramsnya postman
        $limit = $request->limit;

        //cari data berdasarkan yg di search
        $students = Student::where('nama', 'LIKE', '%'.$search.'%')->limit($limit)->get();

        //ambil semua data melalui model
        //$students = Student :: all();
        if ($students){
            //kalau data berhasil diambil
            //ApiFormatter ngikutin ke file Helpers
            //createAPI dari method di helpers
            return ApiFormatter::createAPI(200, 'success', $students);//argumen karena manggil fungsi
        }else{
            //kalau data gagal diambil
            return ApiFormatter::createAPI(400,'failed');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            //validasi data
            $request->validate([
                'nama' => 'required|min:3',
                'nis'=>'required|numeric',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);

            //ngirim data ke table students lewat model Student
            $student = Student::create([
                'nama' => $request->nama,
                'nis'=>$request->nis,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
            ]);

            //cari data baru yang berhasil disimpan, berdasarkan id lewat data id dari $student
            $hasilTambahData = Student::where('id',$student->id)->first();
            if($hasilTambahData){
               //kalau data berhasil diambil
               return ApiFormatter::createAPI(200, 'success', $student);//argumen karena manggil fungsi
            }else{
                //kalau data gagal diambil
                return ApiFormatter::createAPI(400,'failed');
            }
        } catch(Exception $error) {
            //munculin deskripsi error yg bakal tampil di json
            return ApiFormatter::createAPI(400, 'error',$error->getMessage());
        }
    }

    public function createToken()
    {
        return csrf_token();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // coba baris code di try
        try {
            //ambil data dari tabale students yg idnya sama kek $id dari path routenya
            // where nyari berdasarkan semua column, find cuma brdasarkan id
            $student = Student::find($id);
            if($student) {
                // kalau data berhasil di ambil, tampilkan data dari $student dgn tanda status code 200
                return ApiFormatter::createAPI(200, 'success', $student);
            } else {
                // kalau data gagal diambil/data gaada, yg dikembaliin code 400
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            // kalau pas try ada error, deskripsi error dtampilin dgn status 400
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // cek validasi inputn body postman
            $request->validate([
                'nama' => 'required|min:3',
                'nis' => 'required|numeric',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);

            // ambil data yg akn d ubah
            $student = Student::find($id);

            // update data uh udh d ambil
            $student->update([
                'nama' => $request->nama,
                'nis' => $request->nis,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
            ]);

            $dataTerbaru = Student::where('id', $student->id)->first();
            if ($dataTerbaru) {
                // klo update berhasil, tampilkan data dr $updateStudent diatas (data yg udh berhasil)
                return ApiFormatter::createAPI(200, 'success', $dataTerbaru);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            // jika di baris code try ad trouble, error muncul dgn descny dan status 400
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // ambil data yg mw d hapus
            $student = Student::find($id);
            // hapus data yg d ambil
            $cekBerhasil = $student->delete();

            if ($cekBerhasil) {
                // klw berhasil, data yg d munculin teks konfirm dgn code 200
                return ApiFormatter::createAPI(200, 'success', 'Data terhapus');
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
            
        } catch (Exception $error) {
            // klw ad trouble d try, error desc muncul
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function trash()
    {
        try {
            $students = Student::onlyTrashed()->get();
            if ($students) {
                return ApiFormatter::createAPI(200, 'success', $students);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $student = Student::onlyTrashed()->where('id', $id);
            $student->restore();
            $dataKembali = Student::where('id', $id)->first();
            
            if ($dataKembali) {
                return ApiFormatter::createAPI(200, 'success', $dataKembali);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
            
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }
    
    public function perDel($id)
    {
        try {
            $student = Student::onlyTrashed()->where('id', $id);
            $proses = $student->forceDelete();
            if ($proses) {
                return ApiFormatter::createAPI(200, 'success', 'Berhasil hpus data ygy');
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
            
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }
}
