// External Dependencies
import React, { Component, Fragment } from 'react';

import btn1_light from './button-presets/btn-1/light.png';
import btn1_dark from './button-presets/btn-1/dark.png';

import btn3_moon_dark from './button-presets/btn-3/moon-dark.png';
import btn3_moon_light from './button-presets/btn-3/moon-light.png';
import btn3_sun_dark from './button-presets/btn-3/sun-dark.png';
import btn3_sun_light from './button-presets/btn-3/sun-light.png';

import btn4_light from './button-presets/btn-4/light.png';
import btn4_dark from './button-presets/btn-4/dark.png';

import btn5_light from './button-presets/btn-5/light.png';
import btn5_dark from './button-presets/btn-5/dark.png';

import btn6_light from './button-presets/btn-6/light.png';
import btn6_dark from './button-presets/btn-6/dark.png';

import btn7_light from './button-presets/btn-7/light.png';
import btn7_dark from './button-presets/btn-7/dark.png';

// Internal Dependencies
import './style.scss';



class DarkMode extends Component {

  static slug = 'divi_dark_mode';


  render() {


    const style = parseInt(this.props.switch_style);

    return (
      <div className="divi_component" style={{ textAlign: this.props.switch_postion }}>
        <input type="checkbox" id="wp-dark-mode-switch" className="wp-dark-mode-switch" />

        <div className={`wp-dark-mode-switcher wp-dark-mode-ignore style-${style}`}>
          {
            style === 2 ?
              <label htmlFor="wp-dark-mode-switch">
                <div className="toggle"></div>
                <div className="modes">
                  <p className="light">Light</p>
                  <p className="dark">Dark</p>
                </div>
              </label>
              : style === 3 ?
                <Fragment>

                  <img className="sun-light" src={btn3_sun_light} alt="sun-light" />
                  <img className="sun-dark" src={btn3_sun_dark} alt="sun-dark" />
                  <label htmlFor="wp-dark-mode-switch">
                    <div className="toggle"></div>
                  </label>
                  <img className="moon-dark" src={btn3_moon_dark} alt="moon-dark" />
                  <img className="moon-light" src={btn3_moon_light} alt="moon-light" />

                </Fragment>
                : style === 4 ?
                  <Fragment>
                    <p>Light</p>
                    <label htmlFor="wp-dark-mode-switch">
                      <div className="modes">
                        <img className="light" src={btn4_light} alt="light" />
                        <img className="dark" src={btn4_dark} alt="dark" />
                      </div>
                    </label>
                    <p>Dark</p>
                  </Fragment>
                  :
                  style === 5 ?
                    <label htmlFor="wp-dark-mode-switch">
                      <div className="modes">
                        <img className="light" src={btn5_light} alt="light" />
                        <img className="dark" src={btn5_dark} alt="dark" />
                      </div>
                    </label>
                    :
                    style === 6 ?
                      <label htmlFor="wp-dark-mode-switch">
                        <div className="modes">
                          <img className="light" src={btn6_light} alt="light" />
                          <img className="dark" src={btn6_dark} alt="dark" />
                        </div>
                      </label>
                      : style === 7 ?
                        <label htmlFor="wp-dark-mode-switch">
                          <div className="toggle"></div>
                          <div className="modes">
                            <img className="light" src={btn7_light} alt="light" />
                            <img className="dark" src={btn7_dark} alt="dark" />
                          </div>
                        </label>
                        :
                        <label htmlFor="wp-dark-mode-switch">
                          <div className="modes">
                            <img className="light" src={btn1_light} alt="light" />
                            <img className="dark" src={btn1_dark} alt="dark" />
                          </div>
                        </label>
          }

        </div>
      </div>

    )
  }
}

export default DarkMode;
