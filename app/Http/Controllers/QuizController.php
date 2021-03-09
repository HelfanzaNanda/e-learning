<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public $number = 1;
    public function index()
    {
        return view('pages.quiz.index', [
            'questions' => DB::table('mst_question')->get()
        ]);
    }

    public function getData($id_question = null, $number = null)
    {
        if ($id_question) {
            $this->number = $number+1;
            $question = DB::table('mst_question')->where('id', '>', $id_question)->first();
            $answer = DB::table('asm_quiz_answer')
            ->where('id_quizquestion', $question->id)->first();
        }else{
            $question = DB::table('mst_question')->first();
            $answer = DB::table('asm_quiz_answer')
            ->where('id_quizquestion', $question->id)->first();
        }   
        
        return json_encode([
            'status' => true,
            'answer' => $answer,
            'number' => $this->number,
            'question' => $question,
        ]);
    }

    public function store(Request $request)
    {
        try{
            DB::table('asm_quiz_answer')->insert([
                'id_quizquestion' => $request->id_question,
                'answer' => $request->opt
            ]);
    
            return $this->getData($request->id_question, $request->number);
        }catch(\Exception $e){
            return json_encode([
                'status' => false,
                'message' => 'harus pilih jawaban'
            ]);
        }
        
    }

    public function getDataBySidebar($id_question = null, $number)
    {
        if ($id_question) {
            $this->number = $number;
            $question = DB::table('mst_question')
            ->where('id',  $id_question)->first();
            $answer = DB::table('asm_quiz_answer')
            ->where('id_quizquestion', $question->id)->first();
        }else{
            $question = DB::table('mst_question')->first();
            $answer = DB::table('asm_quiz_answer')
            ->where('id_quizquestion', $question->id)->first();
        }
        
        return json_encode([
            'status' => true,
            'answer' => $answer,
            'number' => $this->number,
            'question' => $question,
        ]);
    }

    public function mark($question_id)
    {
        DB::table('mst_question')->where('id', $question_id)->update([
            'remark' => 'yes'
        ]);
        return [
            'status' => true
        ];
    }
}
