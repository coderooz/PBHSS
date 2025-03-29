This is the website for the school named "Pachim Barnagar High School"

Website structure:
    - For Visitors:
        - Index page/Home Page
        - Gallery
        - Contact Page
        - Staff Page
        - notification page
        - Blogs page
        - News page
        - Blogs & News page
        - Downloads page
        - Login Page
        - Signup Page
        - Forgot-password Page
    
    - For Students:
        - 
    
    - For Teachers:
        - 



Website Backend Functionalities:
    - Db Connection
    - Db Query Handle
        - Table Handle
        - Data Handle 
    - Password Verifier
    - Unique Id generator
    - 


School Database Info[Tables]:
    - userbase
        - id
        - unique id
        - user email
        - userpwd
        - usercatg 
            *Consists of 4 different levels according to the accessiblity level.
            - 0: admin/principle/vice-principle
            - 1: teachers
            - 2: students
            - 3: other staff    

    - students
        - id
        - unique id
        - First Name
        - Last Name
        - Father's Name
        - Mother's NAme
        - Phone no
        - Address
        - Blood Group
        - D.O.B
        - Image
        - Roll No
        - Class
        - Unique Identification
        - Age

    - staff
        - id
        - Name
        - Department
        - Working Form
        - image
        - sallary
        - dob
        
    - results
    - events
    - blogsnews
        - 
    - downloads
        - 
    - salary's
    - noteslist
        - id
        - uploaderid
        - name
        - subject
        - title
        - doc link
        - doc type
        - uploadedon

