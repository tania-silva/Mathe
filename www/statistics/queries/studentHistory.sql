SELECT  ast.`date`  as date,
	topic.name as topic,
	subtopic.name as subtopic,
	TRUNCATE(100 *  SUM(IF (answer.guess = 1, 1, 0 )) / 7, 1) as correct
FROM (
SELECT
	id,
	SPLIT_STR(unformatted_answer, "|", 1) as question,
	SPLIT_STR(unformatted_answer, "|", 2) as guess
	FROM (
		SELECT id, qst01 as unformatted_answer FROM platform__SNA__assestment
		UNION ALL
		SELECT id, qst02 FROM platform__SNA__assestment
		UNION ALL
		SELECT id, qst03 FROM platform__SNA__assestment
		UNION ALL
		SELECT id, qst04 FROM platform__SNA__assestment
		UNION ALL
		SELECT id, qst05 FROM platform__SNA__assestment
		UNION ALL
		SELECT id, qst06 FROM platform__SNA__assestment
		UNION ALL
		SELECT id, qst07 FROM platform__SNA__assestment
		) as unformatted_answer
) as answer
JOIN platform__SNA__assestment ast ON ast.id = answer.id
LEFT JOIN platform__topic topic on ast.topic = topic.id
LEFT JOIN platform__subtopic subtopic on ast.subtopic = subtopic.id
WHERE id_stud = ? AND answer.guess <> ""
GROUP BY ast.`date`, topic.id, subtopic.id
ORDER BY ast.`date`;
