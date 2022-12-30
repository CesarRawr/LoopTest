const ListInput = (props) => {
  const customStyles = {
    container: (provided, state) => ({
      ...provided,
      ...props.styles,
    }),
    control: (provided, state) => ({
      ...provided,
      background: '#fafafa',
      borderColor: '#d1d1d1',
      minHeight: '4.5vh',
      border: "1px solid #d1d1d1",
      borderRadius: "4px",
      boxShadow: state.isFocused ? null : null,
    }),
    valueContainer: (provided, state) => ({
      ...provided,
      padding: '0 6px'
    }),
    input: (provided, state) => ({
      ...provided,
      margin: '0px',
    }),
    indicatorsContainer: (provided, state) => ({
      ...provided,
      height: '4.5vh',
    }),
  };

  return (
    <Select
      styles={customStyles}
      isClearable={props.clearable}
      options={props.optionList} 
      placeholder={props.placeholder ? props.placeholder: ""} 
      components={{ DropdownIndicator:() => null, IndicatorSeparator:() => null }}
      onInputChange={inputValue =>
        (inputValue.length <= props.maxLength ? inputValue : inputValue.substr(0, props.maxLength))
      } 
      values={props.value}
      onChange={props.onChange}
      searchable />
  );
}
