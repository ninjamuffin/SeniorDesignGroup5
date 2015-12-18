import csv
import nltk
from operator import itemgetter

"""
Given a string of words (an expression) returns a list of tuples: (fst=word, snd=PoS)
"""
def get_parts_of_speech(expr_str):

	text = expr_str.split(' ')
	return nltk.pos_tag(text)

"""
Given a full table from Expressions.csv, returns a table with:
 	col0=expression_ID, col1=word, col2=PoS
"""
def add_PoS(expressions):

	result_table = []
	for expr_row in expressions:
		expr_ID = int(expr_row[0])
		expr = expr_row[1]
		POS_tuples = get_parts_of_speech(expr)
		for tuple in POS_tuples:
			new_row = [expr_ID, tuple[0], tuple[1]]
			result_table.append(new_row)
	return result_table
	

def lookup_word_id(word, word_table):
	for i in range(len(word_table)):
		if word_table[i][1] == word:
			return int(word_table[i][0])
	return -1
			
def add_word_ID(PoS_Table, word_table):
	word_in_expression = []
	for row in PoS_Table:
		parsed_word = parse_word(row[1])
		word_id = lookup_word_id(parsed_word, word_table)
		new_row = [ row[0], word_id, row[2] ]
		word_in_expression.append(new_row)
	return word_in_expression
				
def parse_word(word):
	new_word = []
	for char in word:
		if char.isalpha() or ord(char) == 39:
			new_word.append(char)
	return ''.join(new_word)

"""
Given a table with columns{expr_id, word, POS} return a parsed list of words with IDs
Remove all symbols and punctuation except for apostrophes

"""
def parse_out_words(full_table):	
	words = []
	for row in full_table:
		add_word = row[1]
		
		word_string = parse_word(add_word)
		words.append([word_string])
	return words
	
	
def read_csv(filename):
    """Reads in a csv file and returns a table as a list of lists (rows)"""
    the_file = open(filename, 'rU')
    
    the_reader = csv.reader(the_file)
    table = []
    for row in the_reader:
        if len(row) > 0:
            table.append(row)
    return table

""" 
Input: list of words
Output: table of [word_ID, word, frequency]
"""
def to_dictionary(words):
	words_ = []
	counts = []
	sorted_words = sorted(words, key=itemgetter(0))
	for word_list in sorted_words:
		word = word_list[0]
		if word not in words_:
			words_.append(word_list[0])
			counts.append(1)
		else:
			counts[-1] += 1
	table = []
	for i in range(len(words_)):
		table.append([i+1, words_[i], counts[i]])
	return table
			    
def writeNewTable(table,nameOfTable):
    """ Given a table and a name of the table, will write the table to a csv file
    using the table name as the file name. The file is written in the directory where this python
    file is launched. """
    file = open(nameOfTable,"w")
    for row in table:
        columnCount = 1
        lastColumn = len(row)
        for column in row:
            if columnCount == lastColumn:
                file.write(str(column))
            else:
                file.write(str(column))
                file.write(",")
            columnCount += 1
        file.write("\n")
    file.close()
 
""" Reads in main expressions table and outputs two tables:
		PoS_table
			[expression_ID, word(unparsed), PoS]
"""
def write_PoS():
	f_name = "Expressions.csv"
	table = read_csv(f_name)
	expressions_table = table[1:]
	PoS_table = add_PoS(expressions_table)
	writeNewTable(PoS_table, "PoS_table.csv")
	   
""" Reads in PoS_table.csv table and writes words.csv """
def write_words_table():
	f_name = "PoS_table.csv"
	word_lists = read_csv(f_name)
	words = parse_out_words(word_lists)
	unique_word_list = to_dictionary(words)
	writeNewTable(unique_word_list, 'words.csv')
	
def write_word_in_expression():
	PoS_f_name = "PoS_table.csv"
	word_f_name = "words.csv"
	PoS_table = read_csv(PoS_f_name)
	word_table = read_csv(word_f_name)
	word_in_expression = add_word_ID(PoS_table, word_table)
	writeNewTable(word_in_expression, "Word_In_Expression.csv")
   
def main():
	#write_PoS()
	#write_words_table()
	write_word_in_expression()
	
main()