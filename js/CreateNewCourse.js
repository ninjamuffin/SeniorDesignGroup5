$(function(){
    $(document).on('click', "button[name='CreateCourse']", function(e) {
        var parentForm = $(this).closest("form");
        var institution = $(parentForm).find("select[name=institution]").val();
        var session = $(parentForm).find("select[name=session]").val();
        var coursename = $(parentForm).find("select[name=coursename]").val();
        var section = $(parentForm).find("select[name=section]").val();
        var teacher = $(parentForm).find("select[name=teacherid]").val();
        alert(teacher);
        $.ajax({
            type: "POST",
            url: "CreateNewCourse.php",
            data: {
                "institutionID" : institution,
                "sessionID" : session,
                "coursetypeID" : coursename,
                "section" : section, 
                "teacherID" : teacher
            },
            success: function(data) {
                location.reload();
            }
        });
    });
});
