<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //DB::table('professions')->truncate();

        //CONSTRUCTOR DE CONSULTAS DE SQL

        /*DB::table('professions')->insert([
        	Desarrollador back-end
        ]);
        DB::table('professions')->insert([
        	'title'=>'Desarrollador front-end'
        ]);

        $professions=DB::select('SELECT id FROM professions WHERE title=?',['Desarrollador back-end']);
        //dd($professions);*/

        //ELOQUENT

        /*********************************
        Profession::create([
            'title'=>'Desarrollador back-end'
        ]);

        Profession::create([
            'title'=>'Desarrollador front-end'
        ]);

        $professionId=Profession::where('title','Desarrollador back-end')->value('id');
        //dd('professionId: '.$professionId);

        factory(Profession::class,18)->create();
        **************************************/

        $professionsArray=[
            'Desarrollador back-end',
            'Desarrollador front-end',
            'Desarrollador web',
            'Médico',
            'Auxiliar Médico',
            'Docente',
            'Maestro',
            'Ingeniero de Sistemas',
            'Ingeniero Mecánico',
            'Ingeniero Industrial',
            'Administrador de Empresas',
            'Contador',
            'Traductor',
            'Ingeniero Mecatrónico',
            'Abogado',
            'Secretaria',
            'Enfermera',
            'Policía',
            'Inspector',
            'Ingeniero Químico',  
        ];

        foreach($professionsArray as $professionElement){
            Profession::create([
                'title'=>$professionElement,
            ]);
        }

    }
}
