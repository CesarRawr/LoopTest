const StudentSelector = ({alumno, setAlumno}) => {
  const [students, setStudents] = React.useState([]);

  React.useEffect(() => {
    fetch('public/php/add-loan/getStudents.php')
    .then(response => response.json())
    .then(data => {
      const items = data.students.map((student) => {
        return {
          ...student,
          label: `${student.nombre} ${student.apellidoPaterno} ${student.apellidoMaterno}`,
          value: student.matricula,
        }
      });

      setStudents(items);
    })
    .catch(err => {
      console.log(err);
    });
  }, []);

  return (
    <ListInput 
      values={alumno}
      onChange={(selectedItem) => {
        setAlumno(selectedItem);
      }}
      placeholder="Estudiante" 
      optionList={students} 
      styles={{
        marginBottom: '.6rem',
      }} 
      clearable />
  );
}