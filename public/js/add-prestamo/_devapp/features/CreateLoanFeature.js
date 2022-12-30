const CreateLoanFeature = () => {
  const [isRedirect, setIsRedirect] = React.useState(false);
  const [selectedDevices, setSelectedDevices] = React.useState([]);
  const [maestro, setMaestro] = React.useState({});
  const [alumno, setAlumno] = React.useState({
    matricula: '',
  });
  const [aula, setAula] = React.useState('');
  const [ee, setEE] = React.useState('');

  const [horas, setHoras] = React.useState({
    inicio: {
      label: '',
      value: '',
    },
    fin: {
      label: '',
      value: '',
    },
  });

  const [title, setTitle] = React.useState('');
  const [isOpen, setIsOpen] = React.useState(false);
  const [description, setDescription] = React.useState('');

  const close = () => {
    setIsOpen(false);
  };

  const redirect = () => {
    location.href = "home.php";
  }

  const openDialog = (title, descripcion) => {
    setTitle(title);
    setDescription(descripcion);
    setIsOpen(true);
  }

  const onClick = (e) => {
    e.preventDefault();

    const date = new Date();
    const fecha = `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`;
    const rootDoc = document.querySelector('#app');

    if(!horas.inicio.label || !horas.fin.label || !ee.nrc || !aula.id || !maestro.noPersonal || !selectedDevices.length) {
      setIsRedirect(false);
      openDialog("Alerta", "No dejes campos vacios");
      return;
    }

    if (horas.inicio.value === horas.fin.value) {
      setIsRedirect(false);
      openDialog("Alerta", "La hora de inicio no puede ser igual a la hora de fin");
      return;
    }    

    if (horas.inicio.value > horas.fin.value) {
      setIsRedirect(false);
      openDialog("Alerta", "La hora de inicio no puede ser mayor a la hora de fin");
      return;
    }

    const loan = {
      fecha,
      horario_entrada: horas.inicio.label,
      horario_salida: horas.fin.label,
      is_active: true,
      nrc_materia: ee.nrc,
      id_aula: aula.id,
      id_usuario: parseInt(rootDoc.dataset.usuario),
      id_profesor: maestro.noPersonal,
      id_alumno: alumno ? alumno.matricula: "",
      dispositivos: selectedDevices.map((dispositivo) => {
        return {
          id: dispositivo.id,
          nombre: dispositivo.nombre,
          prestado: dispositivo.prestado + dispositivo.localPrestado,
          cantidad: dispositivo.cantidad,
        }
      }),
    };

    fetch('public/php/add-loan/postLoan.php', {
      method: "POST",
      body: JSON.stringify(loan),
      headers: {"Content-type": "application/json; charset=UTF-8"}
    })
    .then((response) => {
      return response.json();
    })
    .then(data => {
      if (data.success) {
        setIsRedirect(true);
        openDialog('Genial', 'Prestamo realizado con exito');
        return;
      }

      console.log(data);
      setIsRedirect(false);
      openDialog('Error', 'Algo salió mal');
    })
    .catch(err => {
      console.log(err);
      setIsRedirect(false);
      openDialog('Error', 'Algo salió mal');
    });
  }

  return (
    <div 
      style={{
        padding: '1rem .5rem',
        boxShadow: 'rgba(99, 99, 99, 0.5) 0px 2px 8px 0px',
        borderRadius: '10px',
        backgroundColor: '#fafafa'
      }}>
      <form style={{display: 'flex', flexFlow: 'column', width: '22vw'}}>

        {/* Titulo */}
        <div
          style={{
            display: 'flex', 
            justifyContent: 'center',
            fontSize: '20px',
            padding: '0 0 .3rem 0',
          }}>
          Crear Prestamo
        </div>

        {/* Horas */}
        <HoursSelector horas={horas} setHoras={setHoras} openDialog={openDialog} />

        {/* Nombre del maestro */}
        <TeacherSelector maestro={maestro} setMaestro={setMaestro} openDialog={openDialog} />

        {/* Nombre de alumno */}
        <StudentSelector alumno={alumno} setAlumno={setAlumno} openDialog={openDialog} />

        {/* Experiencia Educativa */}
        <CoursesSelector ee={ee} setEE={setEE} openDialog={openDialog} />
        
        {/* Aula */}
        <ClassroomsSelector aula={aula} setAula={setAula} openDialog={openDialog} />

        {/* Dispositivos */}
        <DeviceSelector 
          values={selectedDevices}
          setValues={setSelectedDevices} openDialog={openDialog} />

        <div
          style={{
            display: 'flex', 
            justifyContent: 'center',
            marginTop: '.2rem',
          }}>
          <MaterialUI.Button variant="contained" disableElevation onClick={onClick}>
            Prestar
          </MaterialUI.Button>
        </div>
      </form>
      <AlertDialog 
        isOpen={isOpen}
        title={title}
        description={description}
        handleClose={isRedirect ? redirect: close} />
    </div>
  );
}
