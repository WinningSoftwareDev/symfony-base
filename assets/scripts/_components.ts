// ----------------------------------------------------------------------------------
// -- This file provides a convenient entrypoint for including all components that --
// -- are required for use within Latte templates. If the component is only ever   --
// -- used inside other Vue components, no need to include it.                     --
// ----------------------------------------------------------------------------------
import {components as AppCoreComponents} from './Plugin/AppCore/_components';
import {components as AppHealthCheckComponents} from './Plugin/AppHealthCheck/_components';

export const components = {
    ...AppCoreComponents,
    ...AppHealthCheckComponents,
}