<?php 
    namespace App\Repositories\Eloquents;
    use App\Repositories\Contacts\AdminInterface;
    use DB;
    use App\Models\Question;
    class questionRepository implements AdminInterface
    {

        protected $question;

        // Constructor to bind model to repo
        public function __construct(Question $question)
        {
            $this->question = $question;
        }

        public  function getBy(){
            return $this->question->orderBy('id','DESC');
        }
        
        public  function getAll(){
            return $this->question->orderBy('id','DESC')->get();
        }
         
        public  function getFirst(){
            return $this->question->orderBy('id','DESC')->first();
        }

        public  function getById($id){
            return $this->question->find($id);
        }
         
        public  function create(array $data){
            $this->question->create($data);
        }
         
        public  function update($id, array $data){
            $this->question->find($id)->update($data);
        }
         
        public  function delete($id){
            $this->question->find($id)->delete();
        }

        public function getQuestionBy($skill_id,$category_id,$level_id,$limit){
            return DB::select("SELECT questions.id,questions.content
                    FROM (((questions
                    INNER JOIN categories ON questions.category_id = categories.id)
                    INNER JOIN levels ON questions.level_id = levels.id)
                    INNER JOIN skills ON questions.skill_id = skills.id)
                    WHERE questions.level_id =$level_id AND questions.category_id = $category_id AND questions.skill_id = $skill_id
                    ORDER BY RAND()
                    LIMIT $limit
                    ;");
        }

        public function getQuestionBySkill($skill_id,$limit){
            return DB::select("SELECT questions.id,questions.content
                    FROM (questions
                    INNER JOIN levels ON questions.level_id = levels.id)
                    WHERE questions.skill_id = $skill_id
                    ORDER BY RAND()
                    LIMIT $limit
                    ;");
        }
    }