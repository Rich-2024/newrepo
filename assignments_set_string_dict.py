
# Exercise 3: Sets


# 1. Create a set of 3 favorite beverages
beverages = set(["coffee", "tea", "juice"])
print("1. Beverages:", beverages)

# 2. Add 2 more items
beverages.update(["soda", "water"])
print("2. Updated beverages:", beverages)

# 3. Check if "microwave" is in the set
mySet = {"oven", "kettle", "microwave", "refrigerator"}
print("3. Is 'microwave' in set?", "microwave" in mySet)

# 4. Remove "kettle"
mySet.discard("kettle")
print("4. After removing 'kettle':", mySet)

# 5. Loop through the set
print("5. Items in mySet:")
for item in mySet:
    print("-", item)

# 6. Add list items to set
mySet2 = {"phone", "charger", "battery", "earphones"}
myList = ["screen", "cable"]
mySet2.update(myList)
print("6. Updated set with list items:", mySet2)

# 7. Join two sets
ages = {20, 25, 30}
first_names = {"Alice", "Bob", "Charlie"}
joined_set = ages.union(first_names)
print("7. Joined sets:", joined_set)

# --------------------------
# Exercise 4: Strings
# --------------------------

# 1. Concatenate integer and string
age = 25
name = "My age is "
print("1. Concatenated string:", name + str(age))

# 2. Remove spaces from all sides and middle
txt = "      Hello,       Uganda!       "
cleaned_txt = txt.strip().replace("       ", " ").replace("  ", " ")
print("2. Cleaned text:", cleaned_txt)

# 3. Convert to uppercase
print("3. Uppercase:", cleaned_txt.upper())

# 4. Replace 'U' with 'V'
print("4. Replace U with V:", cleaned_txt.replace("U", "V"))

# 5. Return 2nd, 3rd, 4th characters
y = "I am proudly Ugandan"
print("5. Characters 2-4:", y[1:4])

# 6. Fix the string error
x = 'All "Data Scientists" are cool!'
print("6. Fixed string:", x)


# Exercise 5: Dictionaries

# 1. Print value of shoe size
Shoes = {
    "brand": "Nick",
    "color": "black",
    "size": 40
}
print("1. Shoe size:", Shoes["size"])

# 2. Change "Nick" to "Adidas"
Shoes["brand"] = "Adidas"
print("2. Updated shoes:", Shoes)
