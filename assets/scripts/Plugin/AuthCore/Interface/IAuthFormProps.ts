import IFormField from './IFormField';

export default interface IAuthFormProps
{
    title: string;
    text: string;
    endpoint: string;
    handler: () => Promise<boolean>;
    name: string;
    data: Record<string, IFormField>;
    token: string;
}