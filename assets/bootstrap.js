import { startStimulusApp } from '@symfony/stimulus-bridge';
import "bootstrap";
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.(j|t)sx?$/
));