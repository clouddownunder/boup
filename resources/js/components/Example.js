import React from 'react';
import ReactDOM from 'react-dom';

function Example() {
    let name='Zauce';
    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-body">
                            <h1 className='text-center'>
                                {name}
                            </h1>
                            <hr/>
                            <h3 className='text-center'>
                                The web portal is temporary down !
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Example;

if (document.getElementById('example')) {
    ReactDOM.render(<Example />, document.getElementById('example'));
}
