#Sql function to split string
$sql_split_function = "CREATE FUNCTION IF NOT EXISTS SPLIT_STR(
  x VARCHAR(255),
  delim VARCHAR(12),
  pos INT
)
RETURNS VARCHAR(255)
RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos),
       LENGTH(SUBSTRING_INDEX(x, delim, pos -1)) + 1),
       delim, '');";

// Most used question
$question_use = "SELECT COUNT(question.id) as use_count, question.id, question.question FROM
	platform__SFA__questions as question
	LEFT JOIN platform__SFA__assquestions as assquestion 
	on assquestion.question = question.question
	LEFT JOIN platform__SFA__assanswer as answer
	on assquestion.id_ass = answer.id_ass
	GROUP BY question.id
	ORDER BY use_count DESC
LIMIT 15;";

// Number of questions per topic/level
$topic_question_count = "SELECT topic.name, topic.id, question.`level`, COUNT(question.id) as question_count FROM
	platform__SFA__questions as question
	INNER JOIN platform__SFA__assquestions as assquestion
	on assquestion.question = question.question
	RIGHT JOIN platform__topic as topic
	on topic.id = question.topic
	GROUP BY topic.id, question.`level`;";

// 5 Tópicos para cada nível mais usados
$topic_use_count = "SELECT topic.name, topic.id, question.`level`,COUNT(question.id) as use_count FROM
	platform__SFA__questions as question
	INNER JOIN platform__SFA__assquestions as assquestions
	on question.question = assquestions.question
	LEFT JOIN platform__SFA__assanswer as answer
	on assquestions.id_ass = answer.id_ass
	RIGHT JOIN platform__topic as topic
	on topic.id = question.topic
	GROUP BY topic.id, question.`level`;";

// 13a Número de exames que participou
$student_exam_count = "SELECT student.id, COUNT(answer.id) as assessment_count FROM
	platform__students student
	LEFT JOIN platform__SFA__assanswer answer
	on student.id_stud = answer.id_stud
	GROUP BY student.id;";
