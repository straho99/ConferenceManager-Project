namespace ConferenceManager.MSSqlConsole
{
    using System;
    using System.Collections.Generic;
    using System.Linq;
    using System.Text;
    using System.Threading.Tasks;

    using ConferenceManager.MSSqlData;
    using ConferenceManager.Models;

    public class ConferenceManagerMSSqlConsole
    {
        private static MSSqlConferenceManagerContext dbContext = new MSSqlConferenceManagerContext();

        public static void Main()
        {
            Console.WriteLine(dbContext.Users.Count());
        }
    }
}
