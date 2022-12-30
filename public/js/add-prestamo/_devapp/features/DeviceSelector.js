const DeviceSelector = ({values, setValues}) => {
  const [devices, setDevices] = React.useState([]);

  React.useEffect(() => {
    fetch('public/php/add-loan/getDevices.php')
    .then(response => response.json())
    .then(data => {
      const items = data.devices.map((item) => {
        return {
          ...item,
          value: item.nombre, 
          stock: item.cantidad, 
          prestado: item.prestado, 
          localPrestado: 0,
          isDisabled: !(item.cantidad-item.prestado),
          get label() {
            return `${this.value} (${this.stock-this.prestado-this.localPrestado})`;
          },
          get labelPrestado() {
            return `${this.value} (${this.localPrestado})`;
          }
        };
      });

      setDevices(items);
    })
    .catch(err => {
      console.log(err);
    });
  }, []);

  const selectOption = (selected, value)=> {
    // Se aumenta la cantidad prestada
    selected[selected.length-1].localPrestado += 1;

    // Verificar si existe el ultimo item en el array value
    const [result] = value.filter((item) => item.value === selected[selected.length-1].value);
    // Si existe el tag, modifica la cantidad, si no, agrega el nuevo item
    const tags = !!result ? (
      value.map((item) => {
        return (item.value !== selected[selected.length-1].value) ? item: {
          ...item,
          localPrestado: item.localPrestado+1,
          value: item.value,
          label: selected[selected.length-1].labelPrestado,
        };
      })
    ):([...value, {
      ...selected[selected.length-1],
      value: selected[selected.length-1].value,
      label: selected[selected.length-1].value,
    }]);

    const stock = selected[selected.length-1].stock;
    const prestado = selected[selected.length-1].prestado;
    const localPrestado = selected[selected.length-1].localPrestado;
    
    if (stock-prestado-localPrestado === 0) selected[selected.length-1].isDisabled = true;

    return tags;
  } 

  const removeValue = (selected, values, options) => {
    // Encontrar item eliminado
    const [itemDeleted] = values.filter((value) => !selected.some((item) => value.value === item.value));
    // Actualizar la opción eliminada
    options = options.map((option) => {
      return option.value !== itemDeleted.value ? (option): (
        option.localPrestado = 0,
        option.isDisabled = false,
        option
      );
    });

    return selected;
  }

  const onChange = (itemsSelected, {action}) => {
    const actions = {
      'select-option': () => selectOption(itemsSelected, values),
      'remove-value': () => removeValue(itemsSelected, values, devices),
    }

    const tags = actions[action]();
    setValues(tags);
  }

  return (
    <MultiSelector 
      options={devices}
      name="dispositivos" 
      placeholder="Dispositivos"
      onChange={onChange} 
      values={values} 
      styles={{
        marginBottom: '.6rem',
      }} />
  );
}

