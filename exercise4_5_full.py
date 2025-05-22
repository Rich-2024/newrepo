# -------------------------------
# Exercise 4: Strings
# -------------------------------

print("\n--- Exercise 4: Strings ---")

# 1. Concatenate an integer and a string
age = 20
msg = "I am " + str(age) + " years old."
print("1. Concatenated message:", msg)

# 2. Remove extra spaces at beginning, middle, and end
txt = "      Hello,       Uganda!       "
clean_txt = " ".join(txt.strip().split())
print("2. Cleaned text:", clean_txt)

# 3. Convert txt to uppercase
print("3. Uppercase text:", clean_txt.upper())

# 4. Replace 'U' with 'V'
print("4. Replaced text:", clean_txt.replace("U", "V"))

# 5. Characters in 2nd, 3rd, and 4th position
y = "I am proudly Ugandan"
print("5. Characters 2-4:", y[1:4])  # Indexing starts at 0

# 6. Fix string with quotation marks
x = 'All "Data Scientists" are cool!'
print("6. Corrected string:", x)

# -------------------------------
# Exercise 5: Dictionaries
# -------------------------------

print("\n--- Exercise 5: Dictionaries ---")

# Initial dictionary
Shoes = {
    "brand": "Nick",
    "color": "black",
    "size": 40
}

# 1. Print shoe size
print("1. Shoe size:", Shoes["size"])

# 2. Change brand to Adidas
Shoes["brand"] = "Adidas"
print("2. Updated brand:", Shoes["brand"])

# 3. Add key/value pair
Shoes["type"] = "sneakers"
print("3. Added type:", Shoes)

# 4. Return list of all keys
print("4. All keys:", list(Shoes.keys()))

# 5. Return list of all values
print("5. All values:", list(Shoes.values()))

# 6. Check if key "size" exists
print("6. 'size' exists?", "size" in Shoes)

# 7. Loop through dictionary
print("7. Looping through dictionary:")
for key, value in Shoes.items():
    print(f"   {key}: {value}")

# 8. Remove "color"
Shoes.pop("color")
print("8. Removed 'color':", Shoes)

# 9. Empty dictionary
Shoes.clear()
print("9. Emptied dictionary:", Shoes)

# 10. Make a copy of a dictionary
Laptop = {
    "brand": "Dell",
    "model": "XPS",
    "year": 2023
}
LaptopCopy = Laptop.copy()
print("10. Original:", Laptop)
print("    Copy    :", LaptopCopy)

# 11. Nested dictionaries
family = {
    "child1": {
        "name": "Alice",
        "age": 10
    },
    "child2": {
        "name": "Bob",
        "age": 8
    }
}
print("11. Nested dictionary:", family)
# Exercise 5: Dictionaries

# 1. Define the Shoes dictionary and print shoe size
Shoes = {
    "brand": "Nick",
    "color": "black",
    "size": 40
}
print("1. Shoe size:", Shoes["size"])

# 2. Change "Nick" to "Adidas"
Shoes["brand"] = "Adidas"
print("2. Updated brand:", Shoes["brand"])

# 3. Add a new key/value pair: "type": "sneakers"
Shoes["type"] = "sneakers"
print("3. Added 'type':", Shoes)

# 4. Return a list of all keys
print("4. All keys:", list(Shoes.keys()))

# 5. Return a list of all values
print("5. All values:", list(Shoes.values()))

# 6. Check if the key "size" exists
print("6. Does 'size' exist?", "size" in Shoes)

# 7. Loop through the dictionary
print("7. Looping through dictionary:")
for key, value in Shoes.items():
    print(f"   {key}: {value}")

# 8. Remove "color" from the dictionary
Shoes.pop("color")
print("8. Removed 'color':", Shoes)

# 9. Empty the dictionary
Shoes.clear()
print("9. Emptied dictionary:", Shoes)

# 10. Create a dictionary and make a copy
Book = {
    "title": "Python Basics",
    "author": "John Doe",
    "year": 2024
}
BookCopy = Book.copy()
print("10. Original Dictionary:", Book)
print("    Copied Dictionary:", BookCopy)

# 11. Show nested dictionaries
Family = {
    "father": {"name": "James", "age": 45},
    "mother": {"name": "Linda", "age": 42},
    "child": {"name": "Emma", "age": 10}
}
print("11. Nested Dictionary:")
for role, info in Family.items():
    print(f"   {role}: {info}")
