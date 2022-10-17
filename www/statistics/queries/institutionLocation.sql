SELECT Alpha_2 as country_code,
		university.name as university,
		COALESCE(professor_count,0) as professor_count,
		COALESCE(student_count,0) as student_count,
		latitude,
		longitude
	FROM platform__university as university
	LEFT JOIN countries on countries.name = university.country
	LEFT JOIN 
		(SELECT name as institution, count(*) as professor_count
		from platform__lecturers as lecturer
		left join platform__university as university on lecturer.uni_name = university.id
		GROUP BY uni_name) as professors on professors.institution = university.name
	LEFT JOIN 
		(SELECT COALESCE(name,"other") as institution, count(*) as student_count
		from platform__students as student
		left join platform__university as university on student.uni_name = university.id
		GROUP BY uni_name
		) as students on students.institution = university.name;
