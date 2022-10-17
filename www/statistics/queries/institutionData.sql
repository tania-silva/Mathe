SELECT institution.country as country,
		institution.country_code,
		institution.institution_count,
		COALESCE(student.student_count,0) as student_count,
		COALESCE(professor.professor_count,0) as professor_count
	FROM 
		(SELECT country,
			Alpha_2 as country_code,
			COUNT(*) as institution_count
		from platform__university as university
		INNER JOIN countries on university.country = countries.name 
		GROUP BY country, country_code
		) AS institution
	LEFT JOIN 
		(SELECT COALESCE(country, "other") as country,
			count(*) as student_count
		FROM platform__students as student
		LEFT JOIN platform__university as university on student.uni_name = university.id
		INNER JOIN countries on countries.name = university.country
		GROUP BY country
		) AS student on student.country = institution.country
	LEFT JOIN 
		(SELECT COALESCE(country, "other") as country,
			count(*) as professor_count
        from platform__lecturers as lecturer
        left join platform__university as university on lecturer.uni_name = university.id
        GROUP BY university.country
		) as professor on professor.country = institution.country;