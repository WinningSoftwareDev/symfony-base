import ICheckResult from './ICheckResult';

export default interface IHealthCheck
{
    check: () => Promise<ICheckResult>;
}