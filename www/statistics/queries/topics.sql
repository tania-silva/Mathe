# Retrueve questions
WITH question_table as (
	SELECT id_ass, qst01 as answer FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst02 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst03 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst04 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst05 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst06 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst07 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst08 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst09 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst10 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst11 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst12 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst13 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst14 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst15 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst16 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst17 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst18 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst19 FROM platform__SFA__assanswer
	UNION ALL
	SELECT id_ass, qst20 FROM platform__SFA__assanswer),
split_question as ( 
	SELECT id_ass, SPLIT_STR(answer, "|", 1) as question, 
	CASE SPLIT_STR(answer, "|", 2) WHEN 1 THEN true ELSE false END as correct from question_table),
answers as (SELECT *, NOT split_question.correct as wrong FROM split_question where question != "")
SELECT topic.id as topic_id,
	topic.name,
	q.`level`,
	SUM(correct) as correct_guesses,
	SUM(wrong) as wrong_guesses,
	SUM(correct + wrong) as answer_count
FROM answers
LEFT JOIN platform__SFA__assquestions q on q.id = answers.question
RIGHT JOIN platform__topic topic on q.topic = topic.id
GROUP BY q.topic, q.`level`;
