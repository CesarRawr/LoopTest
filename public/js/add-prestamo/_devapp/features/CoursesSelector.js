const CoursesSelector = ({ee, setEE}) => {
  const [courses, setCourses] = React.useState([]);

  React.useEffect(() => {
    fetch('public/php/add-loan/getCourses.php')
    .then(response => response.json())
    .then(data => {
      const items = data.courses.map((course) => {
        return {
          ...course,
          label: course.nombre,
          value: course.nrc,
        }
      });

      setCourses(items);
    })
    .catch(err => {
      console.log(err);
    });
  }, []);

  return (
    <ListInput 
      values={ee}
      onChange={(selectedItem) => {
        setEE(selectedItem);
      }}
      placeholder="Materia" 
      optionList={courses} 
      styles={{
        marginBottom: '.6rem',
      }} />
  );
}
