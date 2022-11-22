<?php

use Illuminate\Database\Seeder;
use App\Model\DataFormulir;

class DataFormulirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id'=>'1','id_periode'=>1,'nama_data'=>'Nama Lengkap (Sesuai Akta Kelahiran)','no_urut'=>1,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'2','id_periode'=>1,'nama_data'=>'No. Identitas (NIK)','no_urut'=>2,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'3','id_periode'=>1,'nama_data'=>'NISN','no_urut'=>3,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-07-21 19:42:49','updated_at'=>'2022-07-21 19:42:52','archived_at'=>NULL],
            ['id'=>'4','id_periode'=>1,'nama_data'=>'Jenis Kelamin','no_urut'=>5,'is_archived'=>0,'is_select'=>1,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'5','id_periode'=>1,'nama_data'=>'Tempat Lahir','no_urut'=>6,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'6','id_periode'=>1,'nama_data'=>'Tanggal Lahir','no_urut'=>7,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'7','id_periode'=>1,'nama_data'=>'Agama','no_urut'=>8,'is_archived'=>0,'is_select'=>1,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'8','id_periode'=>1,'nama_data'=>'Alamat Sesuai KTP','no_urut'=>9,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'9','id_periode'=>1,'nama_data'=>'Kecamatan','no_urut'=>10,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'10','id_periode'=>1,'nama_data'=>'Kelurahan','no_urut'=>11,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'11','id_periode'=>1,'nama_data'=>'Kota/Kabupaten','no_urut'=>12,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'12','id_periode'=>1,'nama_data'=>'Provinsi','no_urut'=>13,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'13','id_periode'=>1,'nama_data'=>'Handphone/Whatsapp','no_urut'=>14,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'14','id_periode'=>1,'nama_data'=>'Kewarganegaraan','no_urut'=>15,'is_archived'=>0,'is_select'=>1,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'15','id_periode'=>1,'nama_data'=>'Status Perkawinan','no_urut'=>16,'is_archived'=>0,'is_select'=>1,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-06-14 15:01:04','archived_at'=>NULL],
            ['id'=>'16','id_periode'=>1,'nama_data'=>'Sumber Biaya Kuliah','no_urut'=>17,'is_archived'=>0,'is_select'=>1,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'17','id_periode'=>1,'nama_data'=>'Anak ke-','no_urut'=>18,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'18','id_periode'=>1,'nama_data'=>'Jumlah Saudara','no_urut'=>19,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'19','id_periode'=>1,'nama_data'=>'Tinggi Badan (cm)','no_urut'=>20,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-06-28 15:28:02','archived_at'=>NULL],
            ['id'=>'20','id_periode'=>1,'nama_data'=>'Berat Badan (Kg)','no_urut'=>21,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-06-28 15:28:19','archived_at'=>NULL],
            ['id'=>'21','id_periode'=>1,'nama_data'=>'Penyakit serius yang pernah diderita','no_urut'=>22,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'22','id_periode'=>1,'nama_data'=>'Prestasi yang pernah diraih','no_urut'=>23,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'23','id_periode'=>1,'nama_data'=>'Nama SMA/SMK/MA','no_urut'=>24,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'24','id_periode'=>1,'nama_data'=>'Status Sekolah','no_urut'=>25,'is_archived'=>0,'is_select'=>1,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'25','id_periode'=>1,'nama_data'=>'Alamat Sekolah','no_urut'=>26,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'26','id_periode'=>1,'nama_data'=>'Kota/Kabupaten Sekolah','no_urut'=>27,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'27','id_periode'=>1,'nama_data'=>'Provinsi Sekolah','no_urut'=>28,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'28','id_periode'=>1,'nama_data'=>'Jurusan','no_urut'=>29,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'29','id_periode'=>1,'nama_data'=>'Tahun Ijazah SMA/SMK/MA','no_urut'=>30,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'30','id_periode'=>1,'nama_data'=>'Nomor Ijazah SMA/SMK/MA','no_urut'=>31,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'31','id_periode'=>1,'nama_data'=>'Nama Perusahaan/Instansi','no_urut'=>32,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'32','id_periode'=>1,'nama_data'=>'Status Perusahaan/Instansi','no_urut'=>33,'is_archived'=>0,'is_select'=>1,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'33','id_periode'=>1,'nama_data'=>'Alamat Perusahaan/Instansi','no_urut'=>34,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'34','id_periode'=>1,'nama_data'=>'Kota/Kabupaten Perusahaan/Instansi','no_urut'=>35,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'35','id_periode'=>1,'nama_data'=>'Provinsi Perusahaan/Instansi','no_urut'=>36,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'36','id_periode'=>1,'nama_data'=>'Telepon','no_urut'=>37,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'37','id_periode'=>1,'nama_data'=>'Nama Lengkap Ayah','no_urut'=>38,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'38','id_periode'=>1,'nama_data'=>'Alamat Ayah','no_urut'=>39,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'39','id_periode'=>1,'nama_data'=>'Handphone/Whatsapp Ayah','no_urut'=>40,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'40','id_periode'=>1,'nama_data'=>'Pekerjaan Ayah','no_urut'=>41,'is_archived'=>0,'is_select'=>1,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'41','id_periode'=>1,'nama_data'=>'Pendidikan Ayah','no_urut'=>42,'is_archived'=>0,'is_select'=>1,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'42','id_periode'=>1,'nama_data'=>'Nama Lengkap Ibu','no_urut'=>43,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'43','id_periode'=>1,'nama_data'=>'Alamat Ibu','no_urut'=>44,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'44','id_periode'=>1,'nama_data'=>'Handphone/Whatsapp Ibu','no_urut'=>45,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'45','id_periode'=>1,'nama_data'=>'Pekerjaan Ibu','no_urut'=>46,'is_archived'=>0,'is_select'=>1,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'46','id_periode'=>1,'nama_data'=>'Pendidikan Ibu','no_urut'=>47,'is_archived'=>0,'is_select'=>1,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'47','id_periode'=>1,'nama_data'=>'Nama Lengkap Wali','no_urut'=>48,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'48','id_periode'=>1,'nama_data'=>'Alamat Wali','no_urut'=>49,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'49','id_periode'=>1,'nama_data'=>'Handphone/Whatsapp Wali','no_urut'=>50,'is_archived'=>0,'is_select'=>0,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'50','id_periode'=>1,'nama_data'=>'Pekerjaan Wali','no_urut'=>51,'is_archived'=>0,'is_select'=>1,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'51','id_periode'=>1,'nama_data'=>'Pendidikan Wali','no_urut'=>52,'is_archived'=>0,'is_select'=>1,'is_required'=>0,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL],
            ['id'=>'52','id_periode'=>1,'nama_data'=>'Email','no_urut'=>4,'is_archived'=>0,'is_select'=>0,'is_required'=>1,'created_at'=>'2022-03-21 20:03:45','updated_at'=>'2022-03-21 20:03:45','archived_at'=>NULL]
       ];
       DataFormulir::insert($records);
    }
}
