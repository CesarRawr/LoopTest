const HoursSelector = ({horas, setHoras}) => {
  return (
    <div style={{display: 'flex', flexFlow: 'column', padding: '.5rem 0 .8rem .0rem'}}>
      <div style={{marginBottom: '.5rem',   display: 'flex', justifyContent: 'center'}}>
        Horario
      </div>

      <div style={{display: 'flex', justifyContent: 'center'}}>
        <div
          style={{
            width: "6vw",
          }}>
          <ListInput 
            values={horas.inicio}
            onChange={(itemSelected) => {
              setHoras({
                inicio: itemSelected,
                fin: horas.fin,
              });
            }}
            name="horaInicio" 
            placeholder="Inicio"
            optionList={[
              {value: 7, label: "07:00"},
              {value: 9, label: "09:00"},
              {value: 11, label: "11:00"},
              {value: 13, label: "13:00"},
              {value: 15, label: "15:00"},
              {value: 17, label: "17:00"},
              {value: 19, label: "19:00"}
            ]} 
            size={5}
            styles={{
              marginLeft: ".5rem",
            }} />
        </div>

        <div 
          style={{
            width: "6vw",
          }}>
          <ListInput 
            values={horas.fin}
            onChange={(itemSelected) => {
              setHoras({
                inicio: horas.inicio,
                fin: itemSelected,
              });
            }}
            name="horaFin" 
            placeholder="Fin"
            optionList={[
              {value: 9, label: "09:00"},
              {value: 11, label: "11:00"},
              {value: 13, label: "13:00"},
              {value: 15, label: "15:00"},
              {value: 17, label: "17:00"},
              {value: 19, label: "19:00"},
              {value: 21, label: "21:00"}
            ]} 
            size={5}
            styles={{
              marginLeft: ".7rem",
            }} />
        </div>
      </div>
    </div>
  );
}