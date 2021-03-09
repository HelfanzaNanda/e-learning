<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Quiz10Controller extends Controller
{
    public $number = 1;
    public function index()
    {
        return view('pages.quiz_10_row.index', [
            'questions' => DB::table('mst_question')->get()
        ]);
    }

    public function getData($question_id = null, $number = null, $prev = null)
    {   
        if($prev){
            $this->number = $number-20;
            $questions = DB::table('mst_question')
            ->where('mst_question.id', '>=', $question_id)
            ->select('mst_question.*')
            ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT asm_quiz_answer.id) as answer_id'))
            ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT asm_quiz_answer.answer) as answer '))
            ->leftJoin('asm_quiz_answer', 'mst_question.id', '=', 'asm_quiz_answer.id_quizquestion')
            ->take(10)
            ->groupBy('mst_question.id')->get();
        }else{
            if($question_id){
                $this->number = $number+1;
                $questions = DB::table('mst_question')
                ->where('mst_question.id', '>', $question_id)
                ->select('mst_question.*')
                ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT asm_quiz_answer.id) as answer_id'))
                ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT asm_quiz_answer.answer) as answer '))
                ->leftJoin('asm_quiz_answer', 'mst_question.id', '=', 'asm_quiz_answer.id_quizquestion')
                ->take(10)
                ->groupBy('mst_question.id')->get();
            }else{
                $questions = DB::table('mst_question')
                ->select('mst_question.*')
                ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT asm_quiz_answer.id) as answer_id'))
                ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT asm_quiz_answer.answer) as answer '))
                ->leftJoin('asm_quiz_answer', 'mst_question.id', '=', 'asm_quiz_answer.id_quizquestion')
                ->take(10)
                ->groupBy('mst_question.id')->get();
            }
        }
        return json_encode([
            'status' => true,
            'number' => $this->number,
            'questions' => $questions,
            'isPrev' => $this->number <= 1 ? true : false,
            // 'choices' => $choices,
            // 'selected_choices' => $result_choices
        ]);
    }

    public function store(Request $request)
    {
        try {
            foreach($request->opt as $key => $value){
                DB::table('asm_quiz_answer')->insert([
                    'id_quizquestion' => $key,
                    'answer' => $value
                ]);
            }
           
            return $this->getData($request->id_question, $request->number);
        }catch(\Exception $e){
            return json_encode([
                'status' => false,
                'message' => 'harus pilih salah satu'
            ]);
        }
        
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

    public function getDataBySidebar($id_question = null, $number)
    { 
        if (substr($number, 1, 1)) {
            $idxNumber = substr($number, 1, 1);
        }else{
            $idxNumber = $number;
        }
        $this->number = $number - $idxNumber + 1;
        $questions = DB::table('mst_question')
        ->where('mst_question.id', '>=',($id_question - $idxNumber + 1))
        ->select('mst_question.*')
        ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT asm_quiz_answer.id) as answer_id'))
        ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT asm_quiz_answer.answer) as answer '))
        ->leftJoin('asm_quiz_answer', 'mst_question.id', '=', 'asm_quiz_answer.id_quizquestion')
        ->take(10)
        ->groupBy('mst_question.id')->get();
        
        return json_encode([
            'status' => true,
            'number' => $this->number,
            'questions' => $questions,
        ]);
    }
}
