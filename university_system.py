class Person:
    def display_info(self):
        print("University member.")

    def perform_duty(self):
        print("Performing general university duty.")


class Student(Person):
    def display_info(self):
        print("Student: Registers for programming courses.")

    def perform_duty(self):
        subjects = ["C", "Python", "Java"]
        print("Available courses:", ", ".join(subjects))

        for subject in subjects:
            if subject == "Python":
                print(f"Registered for {subject} (popular and in demand).")
            elif subject == "Java":
                print(f"Registered for {subject} (used in enterprise software).")
            else:
                print(f"Registered for {subject} (foundational language).")


class Lecturer(Person):
    def display_info(self):
        print("Lecturer: Teaches programming courses and evaluates students.")

    def perform_duty(self):
        subject = "Python"
        students = ["Alice", "Brian", "Clare"]

        print(f"Lecturer is grading {subject} assignments.")
        for student in students:
            if student == "Alice":
                grade = 85
            elif student == "Brian":
                grade = 78
            else:
                grade = 90

            status = "Passed" if grade >= 80 else "Needs Improvement"
            print(f"{student}: Grade = {grade}, Status = {status}")


class Staff(Person):
    def display_info(self):
        print("Staff: Handles university operations and leave requests.")

    def perform_duty(self):
        staff_name = "Mr.Jeff"
        requested_days = 5
        salary = 1000000  # UGX
        moved_without_permission = True
        days_moved = 3

        print(f"{staff_name} requested {requested_days} days of leave.")

        if requested_days <= 3:
            print("Leave approved.")
        elif requested_days <= 7:
            print("Leave approved with manager's permission.")
        else:
            print("Leave denied: Too many days requested.")

        if moved_without_permission:
            deduction = (0.10 * salary) * days_moved
            remaining_salary = salary - deduction
            print(f"{staff_name} moved without permission for {days_moved} days.")
            print(f"Salary before deduction: UGX {salary}")
            print(f"Total deduction: UGX {int(deduction)}")
            print(f"Salary after deduction: UGX {int(remaining_salary)}")
        else:
            print(f"{staff_name}'s full salary remains: UGX {salary}")


# --- RUN SYSTEM ---

members = [Student(), Lecturer(), Staff()]

for member in members:
    member.display_info()
    member.perform_duty()
    print("-" * 45)



# sample output

# [Done] exited with code=1 in 0.169 seconds

# [Running] python -u "c:\Users\Richie\python\university_system.py"
# Student: Registers for programming courses.
# Available courses: C, Python, Java
# Registered for C (foundational language).
# Registered for Python (popular and in demand).
# Registered for Java (used in enterprise software).
# ---------------------------------------------
# Lecturer: Teaches programming courses and evaluates students.
# Lecturer is grading Python assignments.
# Alice: Grade = 85, Status = Passed
# Brian: Grade = 78, Status = Needs Improvement
# Clare: Grade = 90, Status = Passed
# ---------------------------------------------
# Staff: Handles university operations and leave requests.
# Mr.Jeff requested 5 days of leave.
# Leave approved with manager's permission.
# Mr.Jeff moved without permission for 3 days.
# Salary before deduction: UGX 1000000
# Total deduction: UGX 300000
# Salary after deduction: UGX 700000
# ---------------------------------------------

# [Done] exited with code=0 in 0.082 seconds
