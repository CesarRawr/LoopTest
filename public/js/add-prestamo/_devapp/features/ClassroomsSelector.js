const ClassroomsSelector = ({aula, setAula}) => {
  const [classrooms, setClassrooms] = React.useState([]);

  React.useEffect(() => {
    fetch('public/php/add-loan/getClassrooms.php')
    .then(response => response.json())
    .then(data => {
      const items = data.classrooms.map((classroom) => {
        return {
          ...classroom,
          label: classroom.nombre,
          value: classroom.id,
        }
      });

      setClassrooms(items);
    })
    .catch(err => {
      console.log(err);
    });
  }, []);

  return (
    <ListInput 
      values={aula}
      onChange={(selectedItem) => {
        setAula(selectedItem);
      }}
      placeholder="Salón" 
      optionList={classrooms} 
      styles={{
        marginBottom: '.6rem',
      }} />
  );
}
