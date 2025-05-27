# Exercise 4: Strings

# 1. Declare two variables (an integer and a string) and concatenate them
num = 25
text = "This is number "
concatenated_result = text + str(num)
print("1. Concatenated result:", concatenated_result)

# 2. Consider the string example and output the string without spaces at the beginning, in the middle, and at the end
txt = "      Hello,       Uganda!       "
clean_txt = txt.strip().replace("  ", " ").strip()  # Strips leading/trailing spaces and reduces internal spaces
print("2. Cleaned string:", clean_txt)

# 3. Convert the value of 'txt' to uppercase
uppercase_txt = txt.upper()
print("3. Uppercase string:", uppercase_txt)

# 4. Replace character 'U' with 'V' in the string above
replaced_txt = txt.replace('U', 'V')
print("4. Replaced string:", replaced_txt)

# 5. Return a range of characters in the 2nd, 3rd, and 4th position in string 'y'
y = "I am proudly Ugandan"
range_chars = y[1:4]  # Extracts characters from index 1 to 3 (2nd, 3rd, and 4th positions)
print("5. Range of characters (2nd, 3rd, and 4th):", range_chars)


# Original code will cause an error because of the unclosed quote on "Data Scientists"
x = 'All "Data Scientists" are cool!' 
print("6. Corrected string:", x)
