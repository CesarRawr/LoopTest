const TeacherSelector = ({maestro, setMaestro}) => {
  const [teachers, setTeachers] = React.useState([]);

  React.useEffect(() => {
    fetch('public/php/add-loan/getTeachers.php')
    .then(response => response.json())
    .then(data => {
      const items = data.teachers.map((teacher) => {
        return {
          ...teacher,
          label: teacher.nombre,
          value: teacher.noPersonal,
        }
      });

      setTeachers(items);
    })
    .catch(err => {
      console.log(err);
    });
  }, []);

  return (
    <ListInput 
      values={maestro}
      onChange={(selectedItem) => {
        setMaestro(selectedItem);
      }}
      placeholder="Profesor" 
      optionList={teachers} 
      styles={{
        marginBottom: '.6rem',
      }} />
  );
}