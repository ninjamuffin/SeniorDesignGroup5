/*
File: basic_views.sql
Author: Brendan Kennedy
Purpose: create views from mySQL databases that display relevant information for text corpus functionality
Further use: embed select statements into php code in corpus website
*/

CREATE VIEW expressions_language AS
	SELECT E.expression 'Expression', L.language_name 'Language'
    FROM mysqldbproject.expressions_full as E, language as L
    WHERE E.language_id = L.language_id;
    
    
CREATE VIEW expressions_topic AS
	SELECT E.expression 'Expression', T.topic_name 'Topic'
    FROM mysqldbproject.expressions_full as E, topic as T
    WHERE E.topic_id = T.topic_id;

CREATE VIEW expr_lang_topic AS
	SELECT E.expression 'Expression', T.topic_name 'Topic', L.language_name 'Language'
    FROM mysqldbproject.expressions_full as E, topic as T, language as L
    WHERE E.topic_id = T.topic_id and
     E.language_id = L.language_id;
     
CREATE VIEW full_expr_info AS
	SELECT E.expression 'Expression', T.topic_name 'Topic', L.language_name 'Language'
    FROM mysqldbproject.expressions_full as E, topic as T, language as L, level as Lev
    WHERE E.topic_id = T.topic_id and
		  E.language_id = L.language_id and
          Lev.Level = '107';